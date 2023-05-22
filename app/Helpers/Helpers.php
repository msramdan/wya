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
