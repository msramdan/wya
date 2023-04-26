<?php

use App\Models\WorkOrder;

function totalWoByStatus($status)
{
    $totalStatus = WorkOrder::where('status_wo', $status)->get();
    return  $totalStatus->count();
}

function totalWoByCategory($category)
{
    $totalCategory = WorkOrder::where('category_wo', $category)->get();
    return  $totalCategory->count();
}

function totalWoByType($type)
{
    $totalType = WorkOrder::where('type_wo', $type)->get();
    return  $totalType->count();
}

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
