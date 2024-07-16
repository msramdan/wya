<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class WorkOrderProcessHasWoDocument extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'work_order_process_id',
        'document_name',
        'description',
        'file'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_WorkOrderProcessHasWoDocument')
            ->logOnly([
                'work_order_process_id',
                'document_name',
                'description',
                'file'
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
        return "WorkOrderProcessHasWoDocument " . $this->document_name . " {$eventName} By "  . $user;
    }
}
