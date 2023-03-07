<?php

namespace App\Http\Controllers;

use App\Models\Kabkot;
use App\Http\Requests\{StoreKabkotRequest, UpdateKabkotRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class KabkotController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:kabkot view')->only('index', 'show');
        $this->middleware('permission:kabkot create')->only('create', 'store');
        $this->middleware('permission:kabkot edit')->only('edit', 'update');
        $this->middleware('permission:kabkot delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $kabkots = Kabkot::with('province:id,provinsi');

            return DataTables::of($kabkots)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('action', 'kabkots.include.action')
                ->toJson();
        }

        return view('kabkots.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kabkots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKabkotRequest $request)
    {
        
        Kabkot::create($request->validated());
        Alert::toast('The kabkot was created successfully.', 'success');
        return redirect()->route('kabkots.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kabkot  $kabkot
     * @return \Illuminate\Http\Response
     */
    public function show(Kabkot $kabkot)
    {
        $kabkot->load('province:id,provinsi');

		return view('kabkots.show', compact('kabkot'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kabkot  $kabkot
     * @return \Illuminate\Http\Response
     */
    public function edit(Kabkot $kabkot)
    {
        $kabkot->load('province:id,provinsi');

		return view('kabkots.edit', compact('kabkot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kabkot  $kabkot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKabkotRequest $request, Kabkot $kabkot)
    {
        
        $kabkot->update($request->validated());
        Alert::toast('The kabkot was updated successfully.', 'success');
        return redirect()
            ->route('kabkots.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kabkot  $kabkot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kabkot $kabkot)
    {
        try {
            $kabkot->delete();
            Alert::toast('The kabkot was deleted successfully.', 'success');
            return redirect()->route('kabkots.index');
        } catch (\Throwable $th) {
            Alert::toast('The kabkot cant be deleted because its related to another table.', 'error');
            return redirect()->route('kabkots.index');
        }
    }
}
