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
use Auth;
use PDF;


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
            if (Auth::user()->roles->first()->hospital_id) {
                $spareparts = $spareparts->where('hospital_id', Auth::user()->roles->first()->hospital_id);
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
                'hospital_id' => 'required|exists:App\Models\Hospital,id',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            //upload QR
            Sparepart::create([
                'barcode' => $request->barcode,
                'sparepart_name' => $request->sparepart_name,
                'merk' => $request->merk,
                'sparepart_type' => $request->sparepart_type,
                'unit_id' => $request->unit_id,
                'estimated_price' => $request->estimated_price,
                'opname' => $request->opname,
                'stock' => $request->stock,
                'hospital_id' => $request->hospital_id,
            ]);
            Alert::toast('The sparepart was created successfully.', 'success');
            return redirect()->route('spareparts.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data failed to save', 'error');
            return redirect()->route('spareparts.index');
        } finally {
            DB::commit();
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
        $sparepart->load('unit_item:id,code_unit',);

        return view('spareparts.edit', compact('sparepart'));
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
                'hospital_id' => 'required|exists:App\Models\Hospital,id',
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
            'hospital_id' => $request->hospital_id,
        ]);

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
        try {
            $sparepart->delete();
            Alert::toast('The sparepart was deleted successfully.', 'success');
            return redirect()->route('spareparts.index');
        } catch (\Throwable $th) {
            Alert::toast('The sparepart cant be deleted because its related to another table.', 'error');
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

    public function print_qr(Request $request, $barcode)
    {
        if (setting_web()->paper_qr_code == '68.0315') {
            $widthQR = 80;
            $hightPaper = 88;
        } else {
            $widthQR = 114;
            $hightPaper = 120;
        }
        $pdf = PDF::loadview('spareparts.qr', [
            'barcode' => $barcode,
            'widthQR' => $widthQR
        ])
            ->setPaper([0, 0, $hightPaper, setting_web()->paper_qr_code], 'landscape');
        return $pdf->stream();
        // return $pdf->download('qr.pdf');
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
}
