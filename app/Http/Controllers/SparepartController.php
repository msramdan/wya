<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Http\Requests\{StoreSparepartRequest, UpdateSparepartRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

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
            $spareparts = Sparepart::with('unit_item:id,code_unit', );

            return DataTables::of($spareparts)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
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
    public function store(StoreSparepartRequest $request)
    {
        
        Sparepart::create($request->validated());
        Alert::toast('The sparepart was created successfully.', 'success');
        return redirect()->route('spareparts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function show(Sparepart $sparepart)
    {
        $sparepart->load('unit_item:id,code_unit', );

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
        $sparepart->load('unit_item:id,code_unit', );

		return view('spareparts.edit', compact('sparepart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSparepartRequest $request, Sparepart $sparepart)
    {
        
        $sparepart->update($request->validated());
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
}
