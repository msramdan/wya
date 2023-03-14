<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Http\Requests\{StoreSparepartRequest, UpdateSparepartRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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
    public function index()
    {
        if (request()->ajax()) {
            $spareparts = Sparepart::with('unit_item:id,code_unit',);

            return DataTables::of($spareparts)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('estimated_price', function ($row) {
                    return rupiah($row->estimated_price);
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
                'stock' => 'nullable',
                'image_qr' => 'nullable',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            //upload QR
            $name = Str::slug($request->barcode, '-');
            $image_qr = $name . '.svg';
            $qr = QrCode::size(100)->format('svg')->generate($request->barcode, '../public/qr/qr_sparepart/' . $image_qr);
            Sparepart::create([
                'barcode' => $request->barcode,
                'sparepart_name' => $request->sparepart_name,
                'merk' => $request->merk,
                'sparepart_type' => $request->sparepart_type,
                'unit_id' => $request->unit_id,
                'estimated_price' => $request->estimated_price,
                'stock' => $request->stock,
                'image_qr' => $image_qr,
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
                'stock' => 'nullable',
                'image_qr' => 'nullable',
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $sparepart = Sparepart::findOrFail($id);


        // delete qr lama
        $file_path = public_path("qr/qr_sparepart/" . $sparepart->image_qr);
        File::delete($file_path);

        // upload baru
        $name = Str::slug($request->barcode, '-');
        $image_qr = $name . '.svg';
        QrCode::size(100)->format('svg')->generate($request->barcode, '../public/qr/qr_sparepart/' . $image_qr);

        $sparepart->update([
            'barcode' => $request->barcode,
            'sparepart_name' => $request->sparepart_name,
            'merk' => $request->merk,
            'sparepart_type' => $request->sparepart_type,
            'unit_id' => $request->unit_id,
            'estimated_price' => $request->estimated_price,
            'stock' => $request->stock,
            'image_qr' => $image_qr,
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
            $file_path = public_path("qr/qr_sparepart/" . $sparepart->image_qr);
            File::delete($file_path);
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

    public function print_qr(Request $request, $id)
    {
        if (setting_web()->paper_qr_code == '68.0315') {
            $widthQR = 80;
            $hightPaper = 88;
        } else {
            $widthQR = 114;
            $hightPaper = 115;
        }
        $sparepart = Sparepart::findOrFail($id);
        $pdf = PDF::loadview('spareparts.qr', [
            'sparepart' => $sparepart,
            'widthQR' => $widthQR
        ])
            ->setPaper([0, 0, $hightPaper, setting_web()->paper_qr_code], 'landscape');
        return $pdf->stream();
        // return $pdf->download('qr.pdf');
    }
}
