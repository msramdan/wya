<?php

namespace App\Http\Controllers;

use App\FormatImport\GenerateSparepartFormat;
use App\Exports\SparepartExport;
use App\Models\Sparepart;
use App\Http\Requests\{ImportSparepartRequest, StoreSparepartRequest, UpdateSparepartRequest};
use App\Imports\SparepartImport;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\UnitItem;
use App\Models\Hospital;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SparepartController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sparepart view')->only('index', 'show');
        $this->middleware('permission:sparepart create')->only('create', 'store');
        $this->middleware('permission:sparepart edit')->only('edit', 'update');
        $this->middleware('permission:sparepart delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $spareparts = Sparepart::with('unit_item:id,code_unit', 'hospital:id,name')->orderBy('spareparts.id', 'DESC');
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $spareparts = $spareparts->where('hospital_id', $request->hospital_id);
            }
            if (session('sessionHospital')) {
                $spareparts = $spareparts->where('hospital_id', session('sessionHospital'));
            }
            return DataTables::of($spareparts)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('estimated_price', function ($row) {
                    return rupiah($row->estimated_price);
                })->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('unit_item', function ($row) {
                    return $row->unit_item ? $row->unit_item->code_unit : '';
                })->addColumn('action', 'spareparts.include.action')
                ->toJson();
        }

        return view('spareparts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('spareparts.create');
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
                'barcode' => 'required|string|min:1|max:200|unique:spareparts,barcode',
                'sparepart_name' => 'required|string|min:1|max:200',
                'merk' => 'required|string|min:1|max:200',
                'sparepart_type' => 'required|string|min:1|max:200',
                'unit_id' => 'required|exists:App\Models\UnitItem,id',
                'estimated_price' => 'required|numeric',
                'opname' => 'required|numeric',
                'stock' => 'nullable',

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // Buat Sparepart baru
            $sparepart = Sparepart::create([
                'barcode' => $request->barcode,
                'sparepart_name' => $request->sparepart_name,
                'merk' => $request->merk,
                'sparepart_type' => $request->sparepart_type,
                'unit_id' => $request->unit_id,
                'estimated_price' => $request->estimated_price,
                'opname' => $request->opname,
                'stock' => $request->stock,
                'hospital_id' =>  session('sessionHospital'),
            ]);

            $insertedId = $sparepart->id;

            if ($sparepart) {
                // Upload foto jika ada
                if ($request->hasFile('file_photo_sparepart')) {
                    $name_photo = $request->name_photo;
                    $file_photo = $request->file('file_photo_sparepart');
                    foreach ($file_photo as $key => $a) {
                        $file_photo_name = $a->hashName();
                        $a->storeAs('public/img/sparepart_photo', $file_photo_name);
                        $dataPhoto = [
                            'sparepart_id' => $insertedId,
                            'name_photo' => $name_photo[$key],
                            'photo' => $file_photo_name,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];
                        DB::table('sparepart_photo')->insert($dataPhoto);
                    }
                }
            }

            DB::commit(); // Panggil commit setelah semua operasi berhasil

            Alert::toast('The sparepart was created successfully.', 'success');
            return redirect()->route('spareparts.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data failed to save', 'error');
            return redirect()->route('spareparts.index');
        }
    }

    public function show(Sparepart $sparepart)
    {
        $sparepart->load('unit_item:id,code_unit',);

        return view('spareparts.show', compact('sparepart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function edit(Sparepart $sparepart)
    {
        $sparepart->load('unit_item:id,code_unit');
        $unitItems = UnitItem::where('hospital_id', $sparepart->hospital_id)
            ->get();
        $photo  = DB::table('sparepart_photo')->where('sparepart_id', $sparepart->id)->get();
        return view('spareparts.edit', compact('sparepart', 'unitItems', 'photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'barcode' => 'required|string|min:1|max:200|unique:spareparts,barcode,' . $id,
                'sparepart_name' => 'required|string|min:1|max:200',
                'merk' => 'required|string|min:1|max:200',
                'sparepart_type' => 'required|string|min:1|max:200',
                'unit_id' => 'required|exists:App\Models\UnitItem,id',
                'estimated_price' => 'required|numeric',
                'opname' => 'required|numeric',
                'stock' => 'nullable',

            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update([
            'barcode' => $request->barcode,
            'sparepart_name' => $request->sparepart_name,
            'merk' => $request->merk,
            'sparepart_type' => $request->sparepart_type,
            'unit_id' => $request->unit_id,
            'estimated_price' => $request->estimated_price,
            'opname' => $request->opname,
            'stock' => $request->stock,
            'hospital_id' =>  session('sessionHospital'),
        ]);

        // hapus photo
        if ($request->id_asal_photo == null) {
            $tidak_terhapus_fittings = [];
        } else {
            $tidak_terhapus_fittings = $request->id_asal_photo;
        }
        $hapus_sparepart_photo = DB::table('sparepart_photo')
            ->where('sparepart_id', '=', $sparepart->id)
            ->whereNotIn('id', $tidak_terhapus_fittings)
            ->get();
        foreach ($hapus_sparepart_photo as $row) {
            DB::table('sparepart_photo')->where('id', $row->id)->delete();
            Storage::disk('local')->delete('public/img/sparepart_photo/' . $row->photo);
        }
        // upload photo baru
        if ($request->hasFile('file_photo_sparepart')) {
            $name_photo = $request->name_photo;
            $file_photo = $request->file('file_photo_sparepart');
            foreach ($file_photo as $key => $a) {
                $file_photo_name = $a->hashName();
                $a->storeAs('public/img/sparepart_photo', $file_photo_name);
                $dataPhoto = [
                    'sparepart_id' => $sparepart->id,
                    'name_photo' => $name_photo[$key],
                    'photo' => $file_photo_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                DB::table('sparepart_photo')->insert($dataPhoto);
            }
        }


        Alert::toast('The sparepart was updated successfully.', 'success');
        return redirect()
            ->route('spareparts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sparepart $sparepart)
    {
        DB::beginTransaction();

        try {
            // Ambil daftar foto yang terkait dengan sparepart
            $sparepart_photos = DB::table('sparepart_photo')
                ->where('sparepart_id', $sparepart->id)
                ->pluck('photo', 'id');

            // Hapus file dari storage
            foreach ($sparepart_photos as $id => $photo) {
                Storage::disk('local')->delete('public/img/sparepart_photo/' . $photo);
            }

            // Hapus record dari database
            DB::table('sparepart_photo')
                ->whereIn('id', $sparepart_photos->keys())
                ->delete();

            // Hapus sparepart
            $sparepart->delete();

            DB::commit();

            Alert::toast('The sparepart was deleted successfully.', 'success');
            return redirect()->route('spareparts.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::toast('The sparepart can\'t be deleted because it\'s related to another table.', 'error');
            return redirect()->route('spareparts.index');
        }
    }

    public function stok_in(Request $request)
    {
        $a = mt_rand(100000, 999999);
        DB::table('sparepart_trace')->insert([
            'qty' => $request->qty,
            'sparepart_id' => $request->sparepart_id,
            'note' => $request->note,
            'no_referensi' => 'SI-' . $a,
            'type' => 'In',
            'user_id' => Auth::user()->id,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $sparepart = Sparepart::findOrFail($request->sparepart_id);
        DB::table('spareparts')
            ->where('id', $request->sparepart_id)
            ->update(['stock' => $sparepart->stock + $request->qty]);

        Alert::toast('Stock In was created successfully.', 'success');
        return redirect()->back();
    }

    public function stok_out(Request $request)
    {
        $a = mt_rand(100000, 999999);
        DB::table('sparepart_trace')->insert([
            'qty' => $request->qty,
            'sparepart_id' => $request->sparepart_id,
            'note' => $request->note,
            'no_referensi' => 'SO-' . $a,
            'type' => 'Out',
            'user_id' => Auth::user()->id,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
        $sparepart = Sparepart::findOrFail($request->sparepart_id);
        DB::table('spareparts')
            ->where('id', $request->sparepart_id)
            ->update(['stock' => $sparepart->stock - $request->qty]);

        Alert::toast('Stock Out was created successfully.', 'success');
        return redirect()->back();
    }

    public function delete_history(Request $request, $id)
    {
        $sparepart_trace = DB::table('sparepart_trace')->where('id', $id)->first();
        $type = $sparepart_trace->type;
        $sparepart = Sparepart::findOrFail($sparepart_trace->sparepart_id);
        if ($type == 'Out') {
            DB::table('spareparts')
                ->where('id', $sparepart_trace->sparepart_id)
                ->update(['stock' => $sparepart->stock + $sparepart_trace->qty]);
        } else {
            DB::table('spareparts')
                ->where('id', $sparepart_trace->sparepart_id)
                ->update(['stock' => $sparepart->stock - $sparepart_trace->qty]);
        }
        DB::table('sparepart_trace')->where('id', $id)->delete();
        Alert::toast('History stock was deleted successfully.', 'success');
        return redirect()->back();
    }

    public function print_qr(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $settQR = Hospital::findOrFail($sparepart->hospital_id);
        if ($settQR->paper_qr_code == '68.0315') {
            $widthQR = 80;
            $hightPaper = 88;
        } else {
            $widthQR = 114;
            $hightPaper = 120;
        }
        $pdf = PDF::loadview('spareparts.qr', [
            'barcode' => $sparepart->barcode,
            'widthQR' => $widthQR
        ])
            ->setPaper([0, 0, $hightPaper, $settQR->paper_qr_code], 'landscape');
        return $pdf->stream();
        // return $pdf->download('qr.pdf');
    }

    public function print_histori(Request $request, $id)
    {
        $sparepart = Sparepart::with('unit_item:id,code_unit')->findOrFail($id);
        $histori = DB::table('sparepart_trace')
            ->where('sparepart_id', $id)
            ->get();
        $hospital = Hospital::find($sparepart->hospital_id);
        $pdf = PDF::loadview('spareparts.history_print', [
            'sparepart' => $sparepart,
            'histori' => $histori,
            'hospital' => $hospital,
        ])->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function export()
    {
        $date = date('d-m-Y');
        $nameFile = 'Daftar-Sparepart' . $date;
        return Excel::download(new SparepartExport(), $nameFile . '.xlsx');
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'import_sparepart' . $date;
        return Excel::download(new GenerateSparepartFormat(), $nameFile . '.xlsx');
    }

    public function import(ImportSparepartRequest $request)
    {
        Excel::import(new SparepartImport, $request->file('import_sparepart'));

        Alert::toast('Sparepart has been successfully imported.', 'success');
        return back();
    }

    public function totalAssetPart(Request $request)
    {
        $month = date('Y-m');
        if (session('sessionHospital') == null) {
            $id = $request->id;
            if ($id != null || $id != '') {
                $query = "SELECT SUM(estimated_price * stock) AS total FROM spareparts
                WHERE hospital_id='$id' ";
            } else {
                $query = "SELECT SUM(estimated_price * stock) AS total FROM spareparts";
            }
        } else {
            $id = session('sessionHospital');
            $query = "SELECT SUM(estimated_price * stock) AS total FROM spareparts
                WHERE hospital_id='$id'";
        }

        $data = DB::select($query);
        if ($data[0]->total != null) {
            return rupiah($data[0]->total);
        } else {
            return rupiah(0);
        }
    }
}
