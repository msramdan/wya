<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use App\Http\Requests\{StoreEquipmentCategoryRequest, UpdateEquipmentCategoryRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class EquipmentCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:equipment category view')->only('index', 'show');
        $this->middleware('permission:equipment category create')->only('create', 'store');
        $this->middleware('permission:equipment category edit')->only('edit', 'update');
        $this->middleware('permission:equipment category delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $equipmentCategories = EquipmentCategory::with('hospital:id,name');
            $equipmentCategories = $equipmentCategories->where('hospital_id', session('sessionHospital'));
            return DataTables::of($equipmentCategories)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('action', 'equipment-categories.include.action')
                ->toJson();
        }

        return view('equipment-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipment-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipmentCategoryRequest $request)
    {
        $attr = $request->validated();
        $attr['hospital_id'] = session('sessionHospital');
        EquipmentCategory::create($attr);
        Alert::toast('The equipmentCategory was created successfully.', 'success');
        return redirect()->route('equipment-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentCategory $equipmentCategory)
    {
        return view('equipment-categories.show', compact('equipmentCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentCategory $equipmentCategory)
    {
        return view('equipment-categories.edit', compact('equipmentCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipmentCategoryRequest $request, EquipmentCategory $equipmentCategory)
    {

        $equipmentCategory->update($request->validated());
        Alert::toast('The equipmentCategory was updated successfully.', 'success');
        return redirect()
            ->route('equipment-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentCategory  $equipmentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(EquipmentCategory $equipmentCategory)
    {
        try {
            $equipmentCategory->delete();
            Alert::toast('The equipmentCategory was deleted successfully.', 'success');
            return redirect()->route('equipment-categories.index');
        } catch (\Throwable $th) {
            Alert::toast('The equipmentCategory cant be deleted because its related to another table.', 'error');
            return redirect()->route('equipment-categories.index');
        }
    }

    public function getEquipmentCategory($hospitalId)
    {
        $data = DB::table('equipment_categories')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
