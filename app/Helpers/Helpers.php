<?php

use App\Models\WorkOrder;

function totalWoByStatus($status, $microFrom, $microTo)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalStatus = WorkOrder::where('status_wo', $status)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)
        ->get();
    return  $totalStatus->count();
}

function totalWoByCategory($category, $microFrom, $microTo)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalCategory = WorkOrder::where('category_wo', $category)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)->get();
    return  $totalCategory->count();
}

function totalWoByType($type, $microFrom, $microTo)
{
    $from = date("Y-m-d H:i:s", substr($microFrom, 0, 10));
    $to = date("Y-m-d H:i:s", substr($microTo, 0, 10));
    $totalType = WorkOrder::where('type_wo', $type)
        ->where('filed_date', '>=', $from)
        ->where('filed_date', '<=', $to)->get();
    return  $totalType->count();
}

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
