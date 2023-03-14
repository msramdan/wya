<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\{StoreEquipmentRequest, UpdateEquipmentRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:equipment view')->only('index', 'show');
        $this->middleware('permission:equipment create')->only('create', 'store');
        $this->middleware('permission:equipment edit')->only('edit', 'update');
        $this->middleware('permission:equipment delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $equipments = Equipment::with('nomenklatur:id,code_nomenklatur', 'equipment_category:id,code_categoty', 'vendor:id,code_vendor', 'equipment_location:id,code_location',);

            return DataTables::of($equipments)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('nomenklatur', function ($row) {
                    return $row->nomenklatur ? $row->nomenklatur->code_nomenklatur : '';
                })->addColumn('equipment_category', function ($row) {
                    return $row->equipment_category ? $row->equipment_category->code_categoty : '';
                })->addColumn('vendor', function ($row) {
                    return $row->vendor ? $row->vendor->code_vendor : '';
                })->addColumn('equipment_location', function ($row) {
                    return $row->equipment_location ? $row->equipment_location->code_location : '';
                })->addColumn('action', 'equipments.include.action')
                ->toJson();
        }

        return view('equipments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentRequest $request)
    {

        Equipment::create($request->validated());
        Alert::toast('The equipment was created successfully.', 'success');
        return redirect()->route('equipment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        $equipment->load('nomenklatur:id,code_nomenklatur', 'equipment_category:id,code_categoty', 'vendor:id,code_vendor', 'equipment_location:id,code_location',);

        return view('equipments.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        $equipment->load('nomenklatur:id,code_nomenklatur', 'equipment_category:id,code_categoty', 'vendor:id,code_vendor', 'equipment_location:id,code_location',);

        return view('equipments.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {

        $equipment->update($request->validated());
        Alert::toast('The equipment was updated successfully.', 'success');
        return redirect()
            ->route('equipment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        try {
            $equipment->delete();
            Alert::toast('The equipment was deleted successfully.', 'success');
            return redirect()->route('equipment.index');
        } catch (\Throwable $th) {
            Alert::toast('The equipment cant be deleted because its related to another table.', 'error');
            return redirect()->route('equipment.index');
        }
    }
}
