<?php

use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Employee;

function totalWoByStatus($status, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalStatus = WorkOrder::where('status_wo', $status)
        ->where('hospital_id', $ids)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)
        ->get();
    return  $totalStatus->count();
}
function totalWoByStatusDetail($status, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalStatusDetail = WorkOrder::whereIn('status_wo', $status)
        ->where('hospital_id', $ids)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)
        ->get();
    return  $totalStatusDetail;
}

function totalWoByCategory($category, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalCategory = WorkOrder::where('category_wo', $category)
        ->where('hospital_id', $ids)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)->get();
    return  $totalCategory->count();
}
function totalWoByCategoryDetail($category, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalCategoryDetail = WorkOrder::whereIn('category_wo', $category)
        ->where('hospital_id', $ids)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)->get();
    return  $totalCategoryDetail;
}

function totalWoByType($type, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalType = WorkOrder::where('type_wo', $type)
        ->where('hospital_id', $ids)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)->get();
    return  $totalType->count();
}
function totalWoByTypeDetail($type, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalTypeDetail = WorkOrder::whereIn('type_wo', $type)
        ->where('hospital_id', $ids)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)->get();
    return  $totalTypeDetail;
}

function persentaseWoType($type, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $total = DB::table('work_order_processes')
        ->join('work_orders', 'work_orders.id', '=', 'work_order_processes.work_order_id')
        ->where('work_orders.hospital_id', $ids)
        ->where('work_orders.type_wo', $type)
        ->where('work_order_processes.schedule_date', '>=', $from)
        ->where('work_order_processes.schedule_date', '<=', $to)
        ->count();
    $totalByType = DB::table('work_order_processes')
        ->join('work_orders', 'work_orders.id', '=', 'work_order_processes.work_order_id')
        ->where('work_orders.hospital_id', $ids)
        ->where('work_orders.type_wo', $type)
        ->where('work_order_processes.status', 'finished')
        ->where('work_order_processes.schedule_date', '>=', $from)
        ->where('work_order_processes.schedule_date', '<=', $to)
        ->count();
    if ($totalByType == 0) {
        return 0;
    } else {
        return ($totalByType / $total) * 100;
    }
}



function persentaseAllType($microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $total = DB::table('work_order_processes')
        ->join('work_orders', 'work_orders.id', '=', 'work_order_processes.work_order_id')
        ->where('work_orders.hospital_id', $ids)
        ->where('work_order_processes.schedule_date', '>=', $from)
        ->where('work_order_processes.schedule_date', '<=', $to)
        ->count();
    $totalByType = DB::table('work_order_processes')
        ->join('work_orders', 'work_orders.id', '=', 'work_order_processes.work_order_id')
        ->where('work_orders.hospital_id', $ids)
        ->where('work_order_processes.status', 'finished')
        ->where('work_order_processes.schedule_date', '>=', $from)
        ->where('work_order_processes.schedule_date', '<=', $to)
        ->count();
    if ($totalByType == 0) {
        return 0;
    } else {
        return ($totalByType / $total) * 100;
    }
}

function Expense($type, $microFrom, $microTo, $ids)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    if ($type == 'Calibration') {
        $query = "SELECT SUM(calibration_performance_calibration_price) AS total FROM work_order_processes join work_orders on work_orders.id = work_order_processes.work_order_id WHERE work_orders.hospital_id= $ids and work_order_processes.work_date >= '$from' AND work_order_processes.work_date <= '$to'";
        $data = DB::select($query);
        if ($data[0]->total != null) {
            return $data[0]->total;
        } else {
            return 0;
        }
    } else if ($type == 'Service') {
        $query = "SELECT SUM(replacement_of_part_service_price) AS total FROM work_order_processes join work_orders on work_orders.id = work_order_processes.work_order_id WHERE work_orders.hospital_id= $ids and work_order_processes.work_date >= '$from' AND work_order_processes.work_date <= '$to'";
        $data = DB::select($query);
        if ($data[0]->total != null) {
            return $data[0]->total;
        } else {
            return 0;
        }
    } else {
        $query = "SELECT SUM(amount) AS total FROM work_order_process_has_replacement_of_parts join work_order_processes on work_order_processes.id = work_order_process_has_replacement_of_parts.work_order_process_id join work_orders on work_orders.id = work_order_processes.work_order_id WHERE work_orders.hospital_id= $ids and work_order_processes.work_date >= '$from' AND work_order_processes.work_date <= '$to'";
        $data = DB::select($query);
        if ($data[0]->total != null) {
            return $data[0]->total;
        } else {
            return 0;
        }
    }
}

function ExpenseTable($ids)
{
    $query = "SELECT SUM(amount) AS total FROM work_order_process_has_replacement_of_parts
    join work_order_processes on work_order_processes.id = work_order_process_has_replacement_of_parts.work_order_process_id WHERE work_order_processes.id= $ids";
    $data = DB::select($query);
    if ($data[0]->total != null) {
        return $data[0]->total;
    } else {
        return 0;
    }
}

function statusProsesWo($type, $ids)
{
    if ($type == 'Finish') {
        $statusProsesWo = DB::table('work_order_processes')
            ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
            ->where('status', 'finished')
            ->where('work_orders.hospital_id', $ids)
            ->get();
        return  $statusProsesWo->count();
    } else if ($type == 'Progress') {
        $statusProsesWo = DB::table('work_order_processes')
            ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
            ->where('status', 'on-progress')
            ->where('work_orders.hospital_id', $ids)
            ->get();
        return  $statusProsesWo->count();
    } else if ($type == 'Ready to Start') {
        $statusProsesWo = DB::table('work_order_processes')
            ->join('work_orders', 'work_order_processes.work_order_id', '=', 'work_orders.id')
            ->where('status', 'ready-to-start')
            ->where('work_orders.hospital_id', $ids)
            ->get();
        return  $statusProsesWo->count();
    }
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function getUser($id)
{

    $data = User::findOrFail($id);
    if ($data) {
        return $data->name;
    } else {
        return "-";
    }
}

function getTeknisi($id)
{

    $data = Employee::findOrFail($id);
    if ($data) {
        return $data->name;
    } else {
        return "-";
    }
}

function getVendor($id)
{
    $data = Vendor::findOrFail($id);
    if ($data) {
        return $data->name_vendor;
    } else {
        return "-";
    }
}

function getNilaiBuku($id, $harga_awal)
{
    $month = date('Y-m');
    $data = DB::table('equipment_reduction_price')
        ->where('equipment_id', $id)
        ->where('month', $month)
        ->first();
    if ($data) {
        return $data->nilai_buku;
    } else {
        return 0;
    }
}


function getMonthIndo($month)
{
    switch ($month) {
        case '01':
            return 'Januari';
            break;
        case '02':
            return 'Februari';
            break;
        case '03':
            return 'Maret';
            break;
        case '04':
            return 'April';
            break;
        case '05':
            return 'Mei';
            break;
        case '06':
            return 'Juni';
            break;
        case '07':
            return 'Juli';
            break;
        case '08':
            return 'Agustus';
            break;
        case '09':
            return 'September';
            break;
        case '10':
            return 'Oktober';
            break;
        case '11':
            return 'November';
            break;
        case '12':
            return 'Desember';
            break;

        default:
            return 'Desember';
            break;
    }
}
