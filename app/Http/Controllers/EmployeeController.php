<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\FormatImport\GenerateEmployeeFormat;
use App\Http\Requests\{ImportEmployeeRequest, StoreEmployeeRequest, UpdateEmployeeRequest};
use App\Models\Department;
use App\Models\EmployeeType;
use App\Models\Position;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:employee view')->only('index', 'show');
        $this->middleware('permission:employee create')->only('create', 'store');
        $this->middleware('permission:employee edit')->only('edit', 'update');
        $this->middleware('permission:employee delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $employees = Employee::with('employee_type:id,name_employee_type', 'department:id,name_department', 'position:id,name_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id', 'hospital:id,name');
            $employees = $employees->where('hospital_id', session('sessionHospital'));

            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('address', function ($row) {
                    return str($row->address)->limit(100);
                })
                ->addColumn('employee_status', function ($row) {
                    if ($row->employee_status) {
                        return 'Aktif';
                    } else {
                        return 'Non Aktif';
                    }
                })
                ->addColumn('employee_type', function ($row) {
                    return $row->employee_type ? $row->employee_type->name_employee_type : '';
                })->addColumn('department', function ($row) {
                    return $row->department ? $row->department->name_department : '';
                })->addColumn('position', function ($row) {
                    return $row->position ? $row->position->name_position : '';
                })->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->provinsi_id : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })->addColumn('action', 'employees.include.action')
                ->toJson();
        }

        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|min:1|max:200',
                'nid_employee' => 'required|string|min:1|max:50',
                'employee_type_id' => 'required|exists:App\Models\EmployeeType,id',
                'employee_status' => 'required|boolean',
                'departement_id' => 'required|exists:App\Models\Department,id',
                'position_id' => 'required|exists:App\Models\Position,id',
                'email' => 'required|string|min:1|max:100',
                'phone' => 'required|string|min:1|max:15',
                'provinsi_id' => 'required|exists:App\Models\Province,id',
                'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
                'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
                'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
                'zip_kode' => 'required|string|min:1|max:10',
                'address' => 'required|string',
                'longitude' => 'required|string|min:1|max:200',
                'latitude' => 'required|string|min:1|max:200',
                'join_date' => 'required|date',
                'photo' => 'required|image|mimes:png,jpg,jpeg',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // upload image
            $photo = $request->file('photo');
            $photo->storeAs('public/img/employee', $photo->hashName());

            Employee::create([
                'name' => $request->name,
                'nid_employee' => $request->nid_employee,
                'employee_type_id' => $request->employee_type_id,
                'employee_status' => $request->employee_status,
                'departement_id' => $request->departement_id,
                'position_id' => $request->position_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'provinsi_id' => $request->provinsi_id,
                'kabkot_id' => $request->kabkot_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'zip_kode' => $request->zip_kode,
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'join_date' => $request->join_date,
                'photo' => $photo->hashName(),
                'hospital_id' => session('sessionHospital')
            ]);

            DB::commit();
            Alert::toast('Karyawan berhasil dibuat.', 'success');
            return redirect()->route('employees.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::toast('Data gagal disimpan', 'error');
            return redirect()->route('employees.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employee->load('employee_type:id,name_employee_type', 'department:id,code_department', 'position:id,code_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id');

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        cekAksesRs($employee->hospital_id);
        $employee->load('employee_type:id,name_employee_type', 'department:id,code_department', 'position:id,code_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id');
        $kabkot = DB::table('kabkots')->where('provinsi_id', $employee->provinsi_id)->get();
        $kecamatan = DB::table('kecamatans')->where('kabkot_id', $employee->kabkot_id)->get();
        $kelurahan = DB::table('kelurahans')->where('kecamatan_id', $employee->kecamatan_id)->get();
        $departments = Department::where('hospital_id', $employee->hospital_id)->get();
        $positions = Position::where('hospital_id', $employee->hospital_id)->get();
        $employeeTypes = EmployeeType::where('hospital_id', $employee->hospital_id)->get();
        return view('employees.edit', compact('employee', 'kabkot', 'kecamatan', 'kelurahan', 'employeeTypes', 'positions', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|min:1|max:200',
                'nid_employee' => 'required|string|min:1|max:50',
                'employee_type_id' => 'required|exists:App\Models\EmployeeType,id',
                'employee_status' => 'required|boolean',
                'departement_id' => 'required|exists:App\Models\Department,id',
                'position_id' => 'required|exists:App\Models\Position,id',
                'email' => 'required|string|min:1|max:100',
                'phone' => 'required|string|min:1|max:15',
                'provinsi_id' => 'required|exists:App\Models\Province,id',
                'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
                'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
                'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
                'zip_kode' => 'required|string|min:1|max:10',
                'address' => 'required|string',
                'longitude' => 'required|string|min:1|max:200',
                'latitude' => 'required|string|min:1|max:200',
                'join_date' => 'required|date',
                'photo'     => 'image|mimes:png,jpg,jpeg',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $employee = Employee::findOrFail($id);

            if ($request->file('photo') != null) {
                Storage::disk('local')->delete('public/img/employee/' . $employee->photo);
                $photo = $request->file('photo');
                $photo->storeAs('public/img/employee', $photo->hashName());
                $employee->update([
                    'photo' => $photo->hashName(),
                ]);
            }

            $employee->update([
                'name' => $request->name,
                'nid_employee' => $request->nid_employee,
                'employee_type_id' => $request->employee_type_id,
                'employee_status' => $request->employee_status,
                'departement_id' => $request->departement_id,
                'position_id' => $request->position_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'provinsi_id' => $request->provinsi_id,
                'kabkot_id' => $request->kabkot_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'zip_kode' => $request->zip_kode,
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'join_date' => $request->join_date
            ]);

            Alert::toast('Data karyawan berhasil diperbarui.', 'success');
            return redirect()->route('employees.index');
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan saat memperbarui data karyawan. Silakan coba lagi.', 'error');
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            Storage::disk('local')->delete('public/img/employee/' . $employee->photo);
            $employee->delete();
            Alert::toast('Karyawan berhasil dihapus.', 'success');
            return redirect()->route('employees.index');
        } catch (\Throwable $th) {
            Alert::toast('Karyawan tidak dapat dihapus karena terkait dengan tabel lain.', 'error');
            return redirect()->route('employees.index');
        }
    }


    public function export()
    {
        $date = date('d-m-Y');
        $nameFile = 'Daftar-Employee' . $date;
        return Excel::download(new EmployeeExport(), $nameFile . '.xlsx');
    }
    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'import_employee' . $date;
        return Excel::download(new GenerateEmployeeFormat(), $nameFile . '.xlsx');
    }

    public function import(ImportEmployeeRequest $request)
    {
        Excel::import(new EmployeeImport, $request->file('import_employees'));
        Alert::toast('Data karyawan berhasil diimpor.', 'success');
        return back();
    }


    public function getPic($hospitalId)
    {
        $data = DB::table('employees')->where('hospital_id', $hospitalId)->get();
        return response()->json(compact('data'));
    }
}
