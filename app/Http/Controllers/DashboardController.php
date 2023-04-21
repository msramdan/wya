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

        // grafik by status
        $grafikByStatus = "SELECT status_wo,COUNT(*) as total FROM work_orders GROUP BY status_wo order by status_wo ASC";
        $ByStatus = DB::select($grafikByStatus);
        // dd($ByStatus);
        // die();


        $arrayLabelGrafikByStatus = [];
        $arrayValueGrafikByStatus = [];
        foreach ($ByStatus as $value) {
            array_push($arrayLabelGrafikByStatus, $value->status_wo);
            array_push($arrayValueGrafikByStatus, $value->total);
        }
        $in = DB::table('sparepart_trace')
            ->where('type', '=', 'In')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        $out = DB::table('sparepart_trace')
            ->where('type', '=', 'Out')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        $sql = "SELECT * FROM `spareparts` WHERE stock < opname limit 10";
        $opname = DB::select($sql);
        return view('dashboard', [
            'vendor' => $vendor,
            'employees' => $employees,
            'in' => $in,
            'out' => $out,
            'dataOpname' => $opname,
            'arrayLabelGrafikByStatus' => json_encode($arrayLabelGrafikByStatus),
            'arrayValueGrafikByStatus' => json_encode($arrayValueGrafikByStatus),
        ]);
    }
}
