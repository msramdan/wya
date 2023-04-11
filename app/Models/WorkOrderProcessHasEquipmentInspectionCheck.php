<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProcessHasEquipmentInspectionCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_process_id', 'information', 'status'
    ];
}
