<?php

namespace App\Http\Controllers;

use App\Exports\NomenklaturExport;
use App\FormatImport\GenerateNomenklaturFormat;
use App\Models\Nomenklatur;
use App\Http\Requests\{StoreNomenklaturRequest, UpdateNomenklaturRequest};
use App\Imports\NomenklaturImport;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

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

    public function import_excel(Request $request)
    {
        Excel::import(new NomenklaturImport, $request->file('file'));
        return redirect()->back();
    }
}
