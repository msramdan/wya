<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\WorkOrder;
use Auth;
use App\Models\Hospital;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));
        $hospitals = Hospital::all();
        $hospital_id = intval($request->query('hospital_id'));
        $sessionId = Auth::user()->roles->first()->hospital_id;
        if ($sessionId == null) {
            if (isset($hospital_id) && !empty($hospital_id)) {
                $ids = $hospital_id;
            } else {
                $ids = Hospital::first()->id;
            }
        } else {
            $ids = Auth::user()->roles->first()->hospital_id;
        }

        $countVendor = Vendor::where('hospital_id', $ids)->count();
        $countEmployee = Employee::where('hospital_id', $ids)->count();
        $countEquipment = Equipment::where('hospital_id', $ids)->count();
        $countWorkOrder = WorkOrder::where('hospital_id', $ids)->count();
        $vendor = Vendor::where('hospital_id', $ids)->get();
        $employees = Employee::where('hospital_id', $ids)->get();

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
            'hispotals' => $hospitals,
            'ids' => $ids,
            'countVendor' => $countVendor,
            'countEmployee' => $countEmployee,
            'countEquipment' => $countEquipment,
            'countWorkOrder' => $countWorkOrder

        ]);
    }
}
