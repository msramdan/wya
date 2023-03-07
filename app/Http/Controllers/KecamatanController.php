<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Http\Requests\{StoreKecamatanRequest, UpdateKecamatanRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class KecamatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kecamatan view')->only('index', 'show');
        $this->middleware('permission:kecamatan create')->only('create', 'store');
        $this->middleware('permission:kecamatan edit')->only('edit', 'update');
        $this->middleware('permission:kecamatan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $kecamatans = Kecamatan::with('kabkot:id,kabupaten_kota');

            return DataTables::of($kecamatans)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->kabupaten_kota : '';
                })->addColumn('action', 'kecamatans.include.action')
                ->toJson();
        }

        return view('kecamatans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kecamatans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKecamatanRequest $request)
    {

        Kecamatan::create($request->validated());
        Alert::toast('The kecamatan was created successfully.', 'success');
        return redirect()->route('kecamatans.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kecamatan $kecamatan)
    {
        $kecamatan->load('kabkot:id,provinsi_id');

		return view('kecamatans.show', compact('kecamatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kecamatan $kecamatan)
    {
        $kecamatan->load('kabkot:id,provinsi_id');

		return view('kecamatans.edit', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKecamatanRequest $request, Kecamatan $kecamatan)
    {

        $kecamatan->update($request->validated());
        Alert::toast('The kecamatan was updated successfully.', 'success');
        return redirect()
            ->route('kecamatans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kecamatan $kecamatan)
    {
        try {
            $kecamatan->delete();
            Alert::toast('The kecamatan was deleted successfully.', 'success');
            return redirect()->route('kecamatans.index');
        } catch (\Throwable $th) {
            Alert::toast('The kecamatan cant be deleted because its related to another table.', 'error');
            return redirect()->route('kecamatans.index');
        }
    }
}
