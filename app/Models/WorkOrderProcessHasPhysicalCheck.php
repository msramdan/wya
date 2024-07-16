<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class WorkOrderProcessHasPhysicalCheck extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['work_order_process_id', 'physical_check', 'physical_health', 'physical_cleanliness'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_WorkOrderProcessHasPhysicalCheck')
            ->logOnly(['work_order_process_id', 'physical_check', 'physical_health', 'physical_cleanliness'])
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
        return "WorkOrderProcessHasPhysicalCheck " . $this->physical_check . " {$eventName} By "  . $user;
    }
}
