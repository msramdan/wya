<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class WorkOrderProcessHasCalibrationPerformance extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'work_order_process_id',
        'tool_performance_check',
        'setting',
        'measurable',
        'reference_value',
        'is_good',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_WorkOrderProcessHasCalibrationPerformance')
            ->logOnly([
                'work_order_process_id',
                'tool_performance_check',
                'setting',
                'measurable',
                'reference_value',
                'is_good',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if (isset(Auth::user()->name)) {
            $user = Auth::user()->name;
        } else {
            $user = "Super Admin";
        }
        return "WorkOrderProcessHasCalibrationPerformance " . $this->tool_performance_check . " {$eventName} By "  . $user;
    }
}
