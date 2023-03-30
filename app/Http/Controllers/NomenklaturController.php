<?php

namespace App\Http\Controllers;

use App\Models\Nomenklatur;
use App\Http\Requests\{StoreNomenklaturRequest, UpdateNomenklaturRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class NomenklaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:nomenklatur view')->only('index', 'show');
        // $this->middleware('permission:nomenklatur create')->only('create', 'store');
        // $this->middleware('permission:nomenklatur edit')->only('edit', 'update');
        // $this->middleware('permission:nomenklatur delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $nomenklaturs = Nomenklatur::query();

            return DataTables::of($nomenklaturs)
                ->addIndexColumn()
                // ->addColumn('created_at', function ($row) {
                //     return $row->created_at->format('d M Y H:i:s');
                // })->addColumn('updated_at', function ($row) {
                //     return $row->updated_at->format('d M Y H:i:s');
                // })
                ->addColumn('action', 'nomenklaturs.include.action')
                ->toJson();
        }

        return view('nomenklaturs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nomenklaturs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNomenklaturRequest $request)
    {

        Nomenklatur::create($request->validated());
        Alert::toast('The nomenklatur was created successfully.', 'success');
        return redirect()->route('nomenklaturs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nomenklatur  $nomenklatur
     * @return \Illuminate\Http\Response
     */
    public function show(Nomenklatur $nomenklatur)
    {
        return view('nomenklaturs.show', compact('nomenklatur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nomenklatur  $nomenklatur
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomenklatur $nomenklatur)
    {
        return view('nomenklaturs.edit', compact('nomenklatur'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nomenklatur  $nomenklatur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNomenklaturRequest $request, Nomenklatur $nomenklatur)
    {

        $nomenklatur->update($request->validated());
        Alert::toast('The nomenklatur was updated successfully.', 'success');
        return redirect()
            ->route('nomenklaturs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nomenklatur  $nomenklatur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomenklatur $nomenklatur)
    {
        try {
            $nomenklatur->delete();
            Alert::toast('The nomenklatur was deleted successfully.', 'success');
            return redirect()->route('nomenklaturs.index');
        } catch (\Throwable $th) {
            Alert::toast('The nomenklatur cant be deleted because its related to another table.', 'error');
            return redirect()->route('nomenklaturs.index');
        }
    }
}
