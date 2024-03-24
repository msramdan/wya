<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Http\Requests\{StoreWorkOrderRequest, UpdateWorkOrderRequest};
use App\Marsweb\Notifications\NotifWhatsappWorkOrderCreated;
use App\Marsweb\Notifications\NotifWhatsappWorkOrderDeleted;
use App\Models\Equipment;
use App\Models\EquipmentLocation;
use App\Models\Hospital;
use App\Models\User;
use App\Models\WorkOrderProcess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $work_order_processes = DB::table('work_order_processes')
                ->select(
                    'work_order_processes.schedule_date',
                    'work_order_processes.status',
                    'work_orders.wo_number',
                    'work_orders.type_wo',
                    'work_orders.category_wo',
                    'equipment.barcode',
                    'hospitals.name as hospital_name',
                )
                ->leftJoin('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                ->leftJoin('equipment', 'work_orders.equipment_id', '=', 'equipment.id')
                ->leftJoin('hospitals', 'work_orders.hospital_id', '=', 'hospitals.id');


            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));
            $equipment_id = intval($request->query('equipment_id'));
            $type_wo = $request->query('type_wo');
            $category_wo = $request->query('category_wo');
            $status_wo =$request->query('status_wo');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $work_order_processes = $work_order_processes->where('work_orders.hospital_id', $request->hospital_id);
            }

            if (Auth::user()->roles->first()->hospital_id) {
                $work_order_processes = $work_order_processes->where('work_orders.hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            // if (isset($start_date) && !empty($start_date)) {
            //     $from = date("Y-m-d", substr($request->query('start_date'), 0, 10));
            //     $work_order_processes = $work_order_processes->whereDate('work_order_processes.schedule_wo', '>=', $from);
            // } else {
            //     $from = date('Y-m-d');
            //     $work_order_processes = $work_order_processes->where('work_order_processes.schedule_wo', '>=', $from);
            // }
            // if (isset($end_date) && !empty($end_date)) {
            //     $to = date("Y-m-d", substr($request->query('end_date'), 0, 10));
            //     $work_order_processes = $work_order_processes->where('work_order_processes.schedule_wo', '<=', $to);
            // } else {
            //     $to = date('Y-m-d');
            //     $work_order_processes = $work_order_processes->where('work_order_processes.schedule_wo', '<=', $to);
            // }

            if (isset($equipment_id) && !empty($equipment_id)) {
                if ($equipment_id != 'All') {
                    $work_order_processes = $work_order_processes->where('work_orders.equipment_id', $equipment_id);
                }
            }
            if (isset($type_wo) && !empty($type_wo)) {
                if ($type_wo != 'All') {
                    $work_order_processes = $work_order_processes->where('work_orders.type_wo', $type_wo);
                }
            }
            if (isset($category_wo) && !empty($category_wo)) {
                if ($category_wo != 'All') {
                    $work_order_processes = $work_order_processes->where('work_orders.category_wo', $category_wo);
                }
            }
            if (isset($status_wo) && !empty($status_wo)) {
                if ($status_wo != 'All') {
                    $work_order_processes = $work_order_processes->where('work_order_processes.status', $status_wo);
                }
            }
            $work_order_processes = $work_order_processes->orderBy('work_order_processes.schedule_wo', 'ASC');
            return DataTables::of($work_order_processes)
                ->addIndexColumn()
                ->toJson();
        }
        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;

        if (Auth::user()->roles->first()->hospital_id) {
            $equimentHospital = Equipment::where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
        } else {
            $equimentHospital = Equipment::all();
        }

        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        $equipment_id = $request->query('equipment_id') ?? null;
        $type_wo = $request->query('type_wo') ?? null;
        $category_wo = $request->query('category_wo') ?? null;
        $status_wo = $request->query('status_wo') !== null ? intval($request->query('status_wo')) : null;
        $hospital_id = $request->query('hospital_id') !== null ? intval($request->query('hospital_id')) : null;
        return view('monitoring', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
            'equipment' => $equimentHospital,
            'equipment_id' => $equipment_id,
            'type_wo' => $type_wo,
            'category_wo' => $category_wo,
            'status_wo' => $status_wo,
            'hospital_id' => $hospital_id,
        ]);
    }
}
