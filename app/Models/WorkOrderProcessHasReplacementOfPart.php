<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class WorkOrderProcessHasReplacementOfPart extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'work_order_process_id',
        'sparepart_id',
        'price',
        'amount',
        'qty'
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_WorkOrderProcessHasReplacementOfPart')
            ->logOnly([
                'work_order_process_id',
                'sparepart_id',
                'price',
                'amount',
                'qty'
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
        return "WorkOrderProcessHasReplacementOfPart " . $this->sparepart_id . " {$eventName} By "  . $user;
    }
}
