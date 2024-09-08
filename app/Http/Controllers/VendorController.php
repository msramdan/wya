<?php

namespace App\Http\Controllers;

use App\Exports\VendorsExport;
use App\FormatImport\GenerateVendorFormat;
use App\Models\Vendor;
use App\Http\Requests\{ImportVendorRequest, StoreVendorRequest, UpdateVendorRequest};
use App\Imports\VendorImport;
use App\Models\CategoryVendor;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vendor view')->only('index', 'show');
        $this->middleware('permission:vendor create')->only('create', 'store');
        $this->middleware('permission:vendor edit')->only('edit', 'update');
        $this->middleware('permission:vendor delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $vendors = Vendor::with('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id', 'hospital:id,name');
            $vendors = $vendors->where('hospital_id', session('sessionHospital'));
            return DataTables::of($vendors)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('category_vendor', function ($row) {
                    return $row->category_vendor ? $row->category_vendor->name_category_vendors : '';
                })->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->provinsi_id : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })->addColumn('action', 'vendors.include.action')
                ->toJson();
        }

        return view('vendors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'code_vendor' => 'required|string|min:1|max:20',
                'name_vendor' => 'required|string|min:1|max:200',
                'category_vendor_id' => 'required|exists:App\Models\CategoryVendor,id',
                'email' => 'required|string|min:1|max:100',
                'provinsi_id' => 'required|exists:App\Models\Province,id',
                'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
                'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
                'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
                'zip_kode' => 'required|string|min:1|max:5',
                'longitude' => 'required|string|min:1|max:100',
                'latitude' => 'required|string|min:1|max:100',
                'address' => 'required|string',
                'name' => 'array',
                'file.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048', // Optional: validate file types and size
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Simpan data vendor
        $vendor = Vendor::create([
            'code_vendor' => $request->code_vendor,
            'name_vendor' => $request->name_vendor,
            'category_vendor_id' => $request->category_vendor_id,
            'email' => $request->email,
            'provinsi_id' => $request->provinsi_id,
            'kabkot_id' => $request->kabkot_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'zip_kode' => $request->zip_kode,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'hospital_id' => session('sessionHospital'),
        ]);

        // Proses file upload
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $key => $file) {
                $name = $file->hashName();
                $file->storeAs('public/img/file_vendor', $name);
                DB::table('vendor_files')->insert([
                    'vendor_id' => $vendor->id,
                    'file' => $name,
                    'name_file' => $request->name_file[$key],
                ]);
            }
        }

        // Proses gambar profil
        if ($request->has('name')) {
            foreach ($request->name as $key => $name) {
                DB::table('vendor_pics')->insert([
                    'vendor_id' => $vendor->id,
                    'name' => $name,
                    'phone' => $request->phone[$key],
                    'email' => $request->email_pic[$key],
                    'remark' => $request->remark[$key],
                ]);
            }
        }

        Alert::toast('Vendor berhasil dibuat.', 'success');
        return redirect()->route('vendors.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        $vendor->load('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id',);

        return view('vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        cekAksesRs($vendor->hospital_id);
        $vendor->load('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,kabupaten_kota', 'kecamatan:id,kecamatan', 'kelurahan:id,kelurahan',);
        $pic = DB::table('vendor_pics')->where('vendor_id', $vendor->id)->get();
        $file = DB::table('vendor_files')->where('vendor_id', $vendor->id)->get();
        $kabkot = DB::table('kabkots')->where('provinsi_id', $vendor->provinsi_id)->get();
        $kecamatan = DB::table('kecamatans')->where('kabkot_id', $vendor->kabkot_id)->get();
        $kelurahan = DB::table('kelurahans')->where('kecamatan_id', $vendor->kecamatan_id)->get();
        $categoryVendors = CategoryVendor::where('hospital_id', session('sessionHospital'))->get();
        return view('vendors.edit', compact('vendor', 'pic', 'file', 'kabkot', 'kecamatan', 'kelurahan', 'categoryVendors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'code_vendor' => 'required|string|min:1|max:20',
                'name_vendor' => 'required|string|min:1|max:200',
                'category_vendor_id' => 'required|exists:App\Models\CategoryVendor,id',
                'email' => 'required|string|min:1|max:100',
                'provinsi_id' => 'required|exists:App\Models\Province,id',
                'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
                'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
                'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
                'zip_kode' => 'required|string|min:1|max:5',
                'longitude' => 'required|string|min:1|max:100',
                'latitude' => 'required|string|min:1|max:100',
                'address' => 'required|string',
                'name' => 'array',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Update data vendor
        $vendor->update([
            'code_vendor' => $request->code_vendor,
            'name_vendor' => $request->name_vendor,
            'category_vendor_id' => $request->category_vendor_id,
            'email' => $request->email,
            'provinsi_id' => $request->provinsi_id,
            'kabkot_id' => $request->kabkot_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'zip_kode' => $request->zip_kode,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'hospital_id' => session('sessionHospital'),
        ]);

        // Hapus file yang tidak dipilih
        $tidak_terhapus_file = $request->id_asal_file ?? [];
        DB::table('vendor_files')
            ->where('vendor_id', $vendor->id)
            ->whereNotIn('id', $tidak_terhapus_file)
            ->get()
            ->each(function ($row) {
                DB::table('vendor_files')->where('id', $row->id)->delete();
                Storage::disk('local')->delete('public/img/file_vendor/' . $row->file);
            });

        // Upload file baru
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $key => $file) {
                $name = $file->hashName();
                $file->storeAs('public/img/file_vendor', $name);
                DB::table('vendor_files')->insert([
                    'vendor_id' => $vendor->id,
                    'file' => $name,
                    'name_file' => $request->name_file[$key],
                ]);
            }
        }

        // Hapus gambar profil yang tidak dipilih
        $tidak_terhapus = $request->id_asal ?? [];
        DB::table('vendor_pics')
            ->where('vendor_id', $vendor->id)
            ->whereNotIn('id', $tidak_terhapus)
            ->delete();

        // Update atau tambahkan gambar profil
        if ($request->name) {
            foreach ($request->name as $key => $name) {
                $data = [
                    'vendor_id' => $vendor->id,
                    'name' => $name,
                    'phone' => $request->phone[$key],
                    'email' => $request->email_pic[$key],
                    'remark' => $request->remark[$key],
                ];

                if ($request->id_asal[$key]) {
                    DB::table('vendor_pics')
                        ->where('id', $request->id_asal[$key])
                        ->update($data);
                } else {
                    DB::table('vendor_pics')->insert($data);
                }
            }
        }

        Alert::toast('Vendor berhasil diperbarui.', 'success');
        return redirect()->route('vendors.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        try {
            $vendor->delete();
            Alert::toast('Vendor berhasil dihapus.', 'success');
            return redirect()->route('vendors.index');
        } catch (\Throwable $th) {
            Alert::toast('Vendor tidak dapat dihapus karena terkait dengan tabel lain.', 'error');
            return redirect()->route('vendors.index');
        }
    }


    public function GetFileVendor($vendor_id)
    {

        $data = DB::table('vendor_files')
            ->where('vendor_id', '=', $vendor_id)
            ->get();
        $output = '';
        $output .= '<div class="carousel-inner">';
        $no = 1;
        foreach ($data as $row) {
            $output .= ' <div class="carousel-item ' . $this->active($no) . '"><embed style="width: 100%;height:500px"
            src="' . Storage::url('public/img/file_vendor/' . $row->file) . '" />
            </div>
          ';
            $no++;
        }
        $output .= '</div>';
        echo $output;
    }

    public function active($no)
    {
        if ($no == 1) {
            return "active";
        }
    }

    public function export()
    {
        $date = date('d-m-Y');
        $nameFile = 'Daftar-Vendors' . $date;
        return Excel::download(new VendorsExport(), $nameFile . '.xlsx');
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'import_vendor' . $date;
        return Excel::download(new GenerateVendorFormat(), $nameFile . '.xlsx');
    }

    public function import(ImportVendorRequest $request)
    {
        Excel::import(new VendorImport, $request->file('import_vendor'));

        Alert::toast('Vendor telah berhasil diimpor.', 'success');
        return back();
    }

    public function getVendor($hospitalId)
    {
        $data = DB::table('vendors')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
