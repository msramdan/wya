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
                    'work_orders.filed_date',
                    'work_orders.type_wo',
                    'work_orders.category_wo',
                    'nomenklaturs.name_nomenklatur',
                    'equipment_locations.location_name',
                    'hospitals.name as hospital_name',
                )
                ->leftJoin('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
                ->leftJoin('equipment', 'work_orders.equipment_id', '=', 'equipment.id')
                ->leftJoin('nomenklaturs', 'equipment.nomenklatur_id', '=', 'nomenklaturs.id')
                ->leftJoin('equipment_locations', 'equipment.equipment_location_id', '=', 'equipment_locations.id')
                ->leftJoin('hospitals', 'work_orders.hospital_id', '=', 'hospitals.id');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $work_order_processes = $work_order_processes->where('work_orders.hospital_id', $request->hospital_id);
            }

            if (Auth::user()->roles->first()->hospital_id) {
                $work_order_processes = $work_order_processes->where('work_orders.hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            $work_order_processes = $work_order_processes->orderBy('work_order_processes.schedule_wo', 'ASC');
            return DataTables::of($work_order_processes)
                ->addIndexColumn()
                ->toJson();
        }
        $hospital_id = $request->query('hospital_id') !== null ? intval($request->query('hospital_id')) : null;
        return view('monitoring', [
            'hospital_id' => $hospital_id,
        ]);
    }
}
