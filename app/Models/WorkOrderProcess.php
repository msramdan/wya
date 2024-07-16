<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;


class WorkOrderProcess extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['work_order_id', 'schedule_date', 'start_date', 'end_date', 'schedule_wo', 'status', 'work_date', 'executor', 'work_executor_vendor_id', 'initial_temperature', 'initial_humidity', 'final_temperature', 'final_humidity', 'mesh_voltage', 'ups', 'grounding', 'leakage_electric', 'electrical_safety_note', 'calibration_performance_is_feasible_to_use', 'calibration_performance_calibration_price', 'replacement_of_part_service_price', 'tools_can_be_used_well',  'tool_cannot_be_used', 'tool_need_repair', 'tool_can_be_used_need_replacement_accessories', 'tool_need_calibration', 'tool_need_bleaching', 'work_executor_technician_id', 'code'];

    public function calibrationPerformance()
    {
        return $this->hasMany(WorkOrderProcessHasCalibrationPerformance::class, 'work_order_process_id', 'id');
    }

    public function physicalChecks()
    {
        return $this->hasMany(WorkOrderProcessHasPhysicalCheck::class, 'work_order_process_id', 'id');
    }

    public function functionChecks()
    {
        return $this->hasMany(WorkOrderProcessHasFunctionCheck::class, 'work_order_process_id', 'id');
    }

    public function equipmentInspectionChecks()
    {
        return $this->hasMany(WorkOrderProcessHasEquipmentInspectionCheck::class, 'work_order_process_id', 'id');
    }

    public function toolMaintenances()
    {
        return $this->hasMany(WorkOrderProcessHasToolMaintenance::class, 'work_order_process_id', 'id');
    }

    public function replacementOfParts()
    {
        return $this->hasMany(WorkOrderProcessHasReplacementOfPart::class, 'work_order_process_id', 'id');
    }

    public function woDocuments()
    {
        return $this->hasMany(WorkOrderProcessHasWoDocument::class, 'work_order_process_id', 'id');
    }

    public function workExecutorTechnician()
    {
        return $this->belongsTo(Employee::class, 'work_executor_technician_id', 'id');
    }

    public function workExecutorVendor()
    {
        return $this->belongsTo(Vendor::class, 'work_executor_vendor_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_work_order_process')
            ->logOnly(['work_order_id', 'schedule_date', 'start_date', 'end_date', 'schedule_wo', 'status', 'work_date', 'executor', 'work_executor_vendor_id', 'initial_temperature', 'initial_humidity', 'final_temperature', 'final_humidity', 'mesh_voltage', 'ups', 'grounding', 'leakage_electric', 'electrical_safety_note', 'calibration_performance_is_feasible_to_use', 'calibration_performance_calibration_price', 'replacement_of_part_service_price', 'tools_can_be_used_well',  'tool_cannot_be_used', 'tool_need_repair', 'tool_can_be_used_need_replacement_accessories', 'tool_need_calibration', 'tool_need_bleaching', 'work_executor_technician_id', 'code'])
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
        return "Work order process " . $this->work_order_id . " {$eventName} By "  . $user;
    }
}
