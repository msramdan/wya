<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Hospital;
use Auth;

class ActivityLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:activity log view')->only('index');
    }


    public function index(Request $request)
    {
        if (request()->ajax()) {
            $activityLog = DB::table('activity_log')
                ->leftJoin('hospitals', 'activity_log.hospital_id', '=', 'hospitals.id')
                ->join('users', 'activity_log.causer_id', '=', 'users.id')
                ->select('activity_log.*', 'hospitals.name as hospital', 'users.name as nama_user');
            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));
            $hospital_id = intval($request->query('hospital_id'));
            $log_name = $request->query('log_name');

            if (isset($start_date) && !empty($start_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $activityLog = $activityLog->where('activity_log.created_at', '>=', $from);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $activityLog = $activityLog->where('activity_log.created_at', '>=', $from);
            }
            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $activityLog = $activityLog->where('activity_log.created_at', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $activityLog = $activityLog->where('activity_log.created_at', '<=', $to);
            }
            if (isset($hospital_id) && !empty($hospital_id)) {
                if ($hospital_id != 'All') {
                    $activityLog = $activityLog->where('activity_log.hospital_id', $hospital_id);
                }
            }
            if (isset($log_name) && !empty($log_name)) {
                if ($log_name != 'All') {
                    $activityLog = $activityLog->where('activity_log.log_name', $log_name);
                }
            }
            if (session('sessionHospital')) {
                $activityLog = $activityLog->where('hospital_id', session('sessionHospital'));
            }
            $activityLog = $activityLog->orderBy('activity_log.id', 'DESC')->get();
            return DataTables::of($activityLog)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital;
                })
                ->addColumn('causer', function ($row) {
                    return $row->nama_user;
                })
                ->addColumn('new_value', function ($row) {
                    $array =  json_decode($row->properties);
                    $items = array();
                    foreach ($array as $key => $value) {
                        if ($key == 'attributes') {
                            foreach ($value as $r => $b) {
                                $items[$r] = $b;
                            }
                        }
                    }
                    $hasil =  json_encode(($items), JSON_PRETTY_PRINT);
                    return $hasil;
                })
                ->addColumn('old_value', function ($row) {
                    $array =  json_decode($row->properties);
                    $items = array();
                    foreach ($array as $key => $value) {
                        if ($key == 'old') {
                            foreach ($value as $r => $b) {
                                $items[$r] = $b;
                            }
                        }
                    }
                    $hasil =  json_encode(($items), JSON_PRETTY_PRINT);
                    return $hasil;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at;
                })
                ->addColumn('time', function ($row) {
                    return Carbon::parse($row->created_at)->diffForHumans();
                })
                ->make(true);
        }

        $currentDate = date('Y-m-d');

        // Get the first and last date of the current month
        $firstDayOfMonth = date('Y-m-01', strtotime($currentDate));
        $lastDayOfMonth = date('Y-m-t', strtotime($currentDate));

        // Convert these dates to timestamps in milliseconds
        $microFrom = strtotime($firstDayOfMonth . " 00:00:00") * 1000;
        $microTo = strtotime($lastDayOfMonth . " 23:59:59") * 1000;

        // Get the start and end dates from the request or use the defaults
        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        $log_name = $request->query('log_name') ?? 'All';
        $hospital_id = $request->query('hospital_id') ?? 'All';

        $arrLog = [
            'log_category_vendor',
            'log_departement',
            'log_employee',
            'log_employee_type',
            'log_equipment',
            'log_equipment_category',
            'log_equipment_location',
            'log_hospital',
            'log_kota',
            'log_kecamatan',
            'log_kelurahan',
            'log_loan',
            'log_nomenklature',
            'log_position',
            'log_provinsi',
            'log_setting',
            'log_sparepart',
            'log_unit_item',
            'log_users',
            'log_backup_database',
            'log_vendor',
            'log_work_order',
            'log_work_order_process',
            'log_WorkOrderProcessHasCalibrationPerformance',
            'log_WorkOrderProcessHasEquipmentInspectionCheck',
            'log_WorkOrderProcessHasFunctionCheck',
            'log_WorkOrderProcessHasPhysicalCheck',
            'log_WorkOrderProcessHasReplacementOfPart',
            'log_WorkOrderProcessHasToolMaintenance',
            'log_users',
            'log_users',
        ];

        return view('activity_log.index', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
            'arrLog' => $arrLog,
            'log_name' => $log_name,
            'hospital_id' => $hospital_id,
            'dataRs' => Hospital::all(),
        ]);
    }
}
