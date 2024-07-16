<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class WorkOrderProcessHasToolMaintenance extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'work_order_process_id', 'information', 'status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_WorkOrderProcessHasToolMaintenance')
            ->logOnly([
                'work_order_process_id', 'information', 'status'
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
        return "WorkOrderProcessHasToolMaintenance " . $this->information . " {$eventName} By "  . $user;
    }
}
