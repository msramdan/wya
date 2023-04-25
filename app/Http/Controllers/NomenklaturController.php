<?php

namespace App\Http\Controllers;

use App\Exports\NomenklaturExport;
use App\FormatImport\GenerateNomenklaturFormat;
use App\Models\Nomenklatur;
use App\Http\Requests\{ImportNomenklaturRequest, StoreNomenklaturRequest, UpdateNomenklaturRequest};
use App\Imports\NomenklaturImport;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class NomenklaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nomenklatur view')->only('index', 'show');
    }

    public function index()
    {
        if (request()->ajax()) {
            $nomenklaturs = Nomenklatur::query();

            return DataTables::of($nomenklaturs)
                ->addIndexColumn()
                ->addColumn('action', 'nomenklaturs.include.action')
                ->toJson();
        }

        return view('nomenklaturs.index');
    }

    public function export()
    {
        $date = date('d-m-Y');
        $nameFile = 'Daftar-Nomenklature' . $date;
        return Excel::download(new NomenklaturExport(), $nameFile . '.xlsx');
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'import_nomenklatur' . $date;
        return Excel::download(new GenerateNomenklaturFormat(), $nameFile . '.xlsx');
    }

    public function import(ImportNomenklaturRequest $request)
    {
        Excel::import(new NomenklaturImport, $request->file('import_nomenklatur'));

        Alert::toast('Nomenklatur has been successfully imported.', 'success');
        return back();
    }
}
