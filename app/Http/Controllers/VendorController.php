<?php

namespace App\Http\Controllers;

use App\Exports\VendorsExport;
use App\FormatImport\GenerateVendorFormat;
use App\Models\Vendor;
use App\Http\Requests\{StoreVendorRequest, UpdateVendorRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
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
    public function index()
    {
        if (request()->ajax()) {
            $vendors = Vendor::with('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id');

            return DataTables::of($vendors)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
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


        $validator = Validator::make(
            $request->all(),
            [
                'code_vendor' => 'required|string|min:1|max:20|unique:vendors,code_vendor',
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
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $vendor =  Vendor::create([
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
        ]);
        $insertedId = $vendor->id;
        if ($vendor) {
            $files = $request->file('file');
            $name_file = $request->name_file;

            if ($request->hasFile('file')) {
                foreach ($files as $key => $file) {
                    $name = $file->hashName();
                    $file->storeAs('public/img/file_vendor', $name);
                    $data = [
                        'vendor_id' => $insertedId,
                        'file' => $name,
                        'name_file' => $name_file[$key],
                    ];

                    DB::table('vendor_files')->insert($data);
                }
            }

            $name_pic = $request->name;
            $phone = $request->phone;
            $email_pic = $request->email_pic;
            $remark = $request->remark;
            if ($name_pic != null) {
                foreach ($name_pic as $key => $value) {
                    $data_pic = [
                        'vendor_id' => $insertedId,
                        'name' => $name_pic[$key],
                        'phone' => $phone[$key],
                        'email' => $email_pic[$key],
                        'remark' => $remark[$key],
                    ];
                    DB::table('vendor_pics')->insert($data_pic);
                }
            }
        }
        Alert::toast('The vendor was created successfully.', 'success');
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
        $vendor->load('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,kabupaten_kota', 'kecamatan:id,kecamatan', 'kelurahan:id,kelurahan',);
        $pic = DB::table('vendor_pics')->where('vendor_id', $vendor->id)->get();
        $file = DB::table('vendor_files')->where('vendor_id', $vendor->id)->get();
        $kabkot = DB::table('kabkots')->where('provinsi_id', $vendor->provinsi_id)->get();
        $kecamatan = DB::table('kecamatans')->where('kabkot_id', $vendor->kabkot_id)->get();
        $kelurahan = DB::table('kelurahans')->where('kecamatan_id', $vendor->kecamatan_id)->get();

        return view('vendors.edit', compact('vendor', 'pic', 'file', 'kabkot', 'kecamatan', 'kelurahan'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'code_vendor' => "required|string||min:1|max:20|unique:vendors,code_vendor," . $vendor->id,
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
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $vendor = Vendor::findOrFail($vendor->id);
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
        ]);

        // hapus file
        if ($request->id_asal_file == null) {
            $tidak_terhapus_file = [];
        } else {
            $tidak_terhapus_file = $request->id_asal_file;
        }
        $hapus_pic = DB::table('vendor_files')
            ->where('vendor_id', '=', $vendor->id)
            ->whereNotIn('id', $tidak_terhapus_file)
            ->get();

        foreach ($hapus_pic as $row) {
            DB::table('vendor_files')->where('id', $row->id)->delete();
            Storage::disk('local')->delete('public/img/file_vendor/' . $row->file);
        }


        $files = $request->file('file');
        $name_file = $request->name_file;
        $asal_file = $request->id_asal_file;
        // dd($asal_file);
        if ($request->hasFile('file')) {
            foreach ($files as $key => $file) {
                // if ($asal_file[$key] == null) {
                $name = $file->hashName();
                $file->storeAs('public/img/file_vendor', $name);
                $data = [
                    'vendor_id' => $vendor->id,
                    'file' => $name,
                    'name_file' => $name_file[$key],
                ];
                DB::table('vendor_files')->insert($data);
                // }
            }
        }

        // hapus pic
        if ($request->id_asal == null) {
            $tidak_terhapus = [];
        } else {
            $tidak_terhapus = $request->id_asal;
        }
        $hapus_pic = DB::table('vendor_pics')
            ->where('vendor_id', '=', $vendor->id)
            ->whereNotIn('id', $tidak_terhapus)
            ->get();
        foreach ($hapus_pic as $row) {
            DB::table('vendor_pics')->where('id', $row->id)->delete();
        }

        // insert or updae pic
        $name_pic = $request->name;
        $phone = $request->phone;
        $email_pic = $request->email_pic;
        $remark = $request->remark;
        $asal = $request->id_asal;

        if ($name_pic != null) {
            foreach ($name_pic as $key => $value) {
                if ($asal[$key] != null) {
                    $vendor_pics = DB::table('vendor_pics')
                        ->where('id', '=', $asal[$key])
                        ->first();
                    if ($vendor_pics) {
                        DB::table('vendor_pics')
                            ->where('id', $vendor_pics->id)
                            ->update([
                                'vendor_id' => $vendor->id,
                                'name' => $name_pic[$key],
                                'phone' => $phone[$key],
                                'email' => $email_pic[$key],
                                'remark' => $remark[$key],
                            ]);
                    }
                } else {
                    $data_pic = [
                        'vendor_id' => $vendor->id,
                        'name' => $name_pic[$key],
                        'phone' => $phone[$key],
                        'email' => $email_pic[$key],
                        'remark' => $remark[$key],
                    ];
                    DB::table('vendor_pics')->insert($data_pic);
                }
            }
        }


        Alert::toast('The vendor was updated successfully.', 'success');
        return redirect()
            ->route('vendors.index');
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
            Alert::toast('The vendor was deleted successfully.', 'success');
            return redirect()->route('vendors.index');
        } catch (\Throwable $th) {
            Alert::toast('The vendor cant be deleted because its related to another table.', 'error');
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
}
