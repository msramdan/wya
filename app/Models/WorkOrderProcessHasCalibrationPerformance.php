<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProcessHasCalibrationPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_process_id',
        'tool_performance_check',
        'setting',
        'measurable',
        'reference_value',
        'is_good',
    ];
}
