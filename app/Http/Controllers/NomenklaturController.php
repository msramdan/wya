<?php

namespace App\Http\Controllers;

use App\Exports\NomenklaturExport;
use App\Models\Nomenklatur;
use App\Http\Requests\{StoreNomenklaturRequest, UpdateNomenklaturRequest};
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;


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
}
