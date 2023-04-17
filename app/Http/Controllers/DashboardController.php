<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\Employee;


class DashboardController extends Controller
{
    public function index()
    {
        $vendor = Vendor::with('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id')->get();
        $employees = Employee::with('employee_type:id,name_employee_type', 'department:id,name_department', 'position:id,name_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id')->get();

        return view('dashboard', [
            'vendor' => $vendor,
            'employees' => $employees,
        ]);
    }
}
