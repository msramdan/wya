<?php

namespace App\Http\Controllers;

use App\Models\EquipmentLocation;
use App\Http\Requests\{StoreEquipmentLocationRequest, UpdateEquipmentLocationRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class EquipmentLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:equipment location view')->only('index', 'show');
        $this->middleware('permission:equipment location create')->only('create', 'store');
        $this->middleware('permission:equipment location edit')->only('edit', 'update');
        $this->middleware('permission:equipment location delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $equipmentLocations = EquipmentLocation::query();

            return DataTables::of($equipmentLocations)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'equipment-locations.include.action')
                ->toJson();
        }

        return view('equipment-locations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipment-locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentLocationRequest $request)
    {
        
        EquipmentLocation::create($request->validated());
        Alert::toast('The equipmentLocation was created successfully.', 'success');
        return redirect()->route('equipment-locations.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentLocation $equipmentLocation)
    {
        return view('equipment-locations.show', compact('equipmentLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentLocation $equipmentLocation)
    {
        return view('equipment-locations.edit', compact('equipmentLocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentLocationRequest $request, EquipmentLocation $equipmentLocation)
    {
        
        $equipmentLocation->update($request->validated());
        Alert::toast('The equipmentLocation was updated successfully.', 'success');
        return redirect()
            ->route('equipment-locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentLocation  $equipmentLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentLocation $equipmentLocation)
    {
        try {
            $equipmentLocation->delete();
            Alert::toast('The equipmentLocation was deleted successfully.', 'success');
            return redirect()->route('equipment-locations.index');
        } catch (\Throwable $th) {
            Alert::toast('The equipmentLocation cant be deleted because its related to another table.', 'error');
            return redirect()->route('equipment-locations.index');
        }
    }
}