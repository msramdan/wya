<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\Employee;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Vendor::with('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id')->get();
        $employees = Employee::with('employee_type:id,name_employee_type', 'department:id,name_department', 'position:id,name_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id')->get();
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));

        $in = DB::table('sparepart_trace')
            ->where('type', '=', 'In')
            ->limit(10);
        $out = DB::table('sparepart_trace')
            ->where('type', '=', 'Out')
            ->limit(10);
        if (isset($start_date) && !empty($start_date)) {
            $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
            $microFrom = $start_date;
            $in = $in->where('created_at', '>=', $from);
            $out = $out->where('created_at', '>=', $from);
        } else {
            $from = date('Y-m-d') . " 00:00:00";
            $microFrom = strtotime($from) * 1000;
            $in = $in->where('created_at', '>=', $from);
            $out = $out->where('created_at', '>=', $from);
        }
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
            $microTo = $end_date;
            $in = $in->where('created_at', '<=', $to);
            $out = $out->where('created_at', '<=', $to);
        } else {
            $to = date('Y-m-d') . " 23:59:59";
            $microTo = strtotime($to) * 1000;
            $in = $in->where('created_at', '<=', $to);
            $out = $out->where('created_at', '<=', $to);
        }
        $sql = "SELECT * FROM `spareparts` WHERE stock < opname limit 10";
        return view('dashboard', [
            'vendor' => $vendor,
            'employees' => $employees,
            'microFrom' => $microFrom,
            'microTo' => $microTo,
            'in' => $in->orderBy('id', 'desc')->get(),
            'out' => $out->orderBy('id', 'desc')->get(),
            'dataOpname' => DB::select($sql),
        ]);
    }
}
