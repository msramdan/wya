<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class WorkOrder extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['equipment_id', 'type_wo', 'filed_date', 'category_wo', 'schedule_date', 'note', 'created_by', 'status_wo', 'wo_number', 'approval_users_id', 'start_date', 'end_date', 'schedule_wo', 'approved_at', 'tools_can_be_used_well', 'tool_cannot_be_used', 'tool_need_repair', 'tool_can_be_used_need_replacement_accessories', 'tool_need_calibration', 'tool_need_bleaching', 'actual_start_date', 'actual_end_date', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['filed_date' => 'date:d/m/Y', 'schedule_date' => 'date:d/m/Y', 'note' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function equipment()
    {
        return $this->belongsTo(\App\Models\Equipment::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    public function countWoProcess($status = null)
    {
        return WorkOrderProcess::where('work_order_id', $this->id)->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->count();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_work_order')
            ->logOnly(['equipment_id', 'type_wo', 'filed_date', 'category_wo', 'schedule_date', 'note', 'created_by', 'status_wo', 'wo_number', 'approval_users_id', 'start_date', 'end_date', 'schedule_wo', 'approved_at', 'tools_can_be_used_well', 'tool_cannot_be_used', 'tool_need_repair', 'tool_can_be_used_need_replacement_accessories', 'tool_need_calibration', 'tool_need_bleaching', 'actual_start_date', 'actual_end_date', 'hospital_id'])
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
        return "Work Order " . $this->type_wo . " {$eventName} By "  . $user;
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            $lastLog = Activity::where('log_name', 'log_work_order')
                ->where('subject_id', $model->id)
                ->where('subject_type', get_class($model))
                ->latest()
                ->first();

            if ($lastLog) {
                $lastLog->hospital_id = $model->hospital_id;
                $lastLog->save();
            }
        });
    }
}
