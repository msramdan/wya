<?php

namespace App\Http\Controllers;

use App\Models\EmployeeType;
use App\Http\Requests\{StoreEmployeeTypeRequest, UpdateEmployeeTypeRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:employee type view')->only('index', 'show');
        $this->middleware('permission:employee type create')->only('create', 'store');
        $this->middleware('permission:employee type edit')->only('edit', 'update');
        $this->middleware('permission:employee type delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $employeeTypes = EmployeeType::query();

            return DataTables::of($employeeTypes)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'employee-types.include.action')
                ->toJson();
        }

        return view('employee-types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeTypeRequest $request)
    {
        
        EmployeeType::create($request->validated());
        Alert::toast('The employeeType was created successfully.', 'success');
        return redirect()->route('employee-types.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeType  $employeeType
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeType $employeeType)
    {
        return view('employee-types.show', compact('employeeType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeType  $employeeType
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeType $employeeType)
    {
        return view('employee-types.edit', compact('employeeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeType  $employeeType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeTypeRequest $request, EmployeeType $employeeType)
    {
        
        $employeeType->update($request->validated());
        Alert::toast('The employeeType was updated successfully.', 'success');
        return redirect()
            ->route('employee-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeType  $employeeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeType $employeeType)
    {
        try {
            $employeeType->delete();
            Alert::toast('The employeeType was deleted successfully.', 'success');
            return redirect()->route('employee-types.index');
        } catch (\Throwable $th) {
            Alert::toast('The employeeType cant be deleted because its related to another table.', 'error');
            return redirect()->route('employee-types.index');
        }
    }
}