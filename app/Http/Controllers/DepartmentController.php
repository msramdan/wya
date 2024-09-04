<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\{StoreDepartmentRequest, UpdateDepartmentRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:department view')->only('index', 'show');
        $this->middleware('permission:department create')->only('create', 'store');
        $this->middleware('permission:department edit')->only('edit', 'update');
        $this->middleware('permission:department delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $departments = Department::query();
            $departments = $departments->where('hospital_id', session('sessionHospital'));

            return DataTables::of($departments)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })

                ->addColumn('action', 'departments.include.action')
                ->toJson();
        }

        return view('departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $attr = $request->validated();
        $attr['hospital_id'] = session('sessionHospital');
        Department::create($attr);
        Alert::toast('The department was created successfully.', 'success');
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        cekAksesRs($department->hospital_id);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {

        $department->update($request->validated());
        Alert::toast('The department was updated successfully.', 'success');
        return redirect()
            ->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {
            $department->delete();
            Alert::toast('The department was deleted successfully.', 'success');
            return redirect()->route('departments.index');
        } catch (\Throwable $th) {
            Alert::toast('The department cant be deleted because its related to another table.', 'error');
            return redirect()->route('departments.index');
        }
    }

    public function getDepartment($hospitalId)
    {
        $data = DB::table('departments')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
