<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Sparepart extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['barcode', 'sparepart_name', 'merk', 'sparepart_type', 'unit_id', 'estimated_price', 'opname', 'stock', 'hospital_id'];

    public function unit_item()
    {
        return $this->belongsTo(\App\Models\UnitItem::class, 'unit_id');
    }

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_sparepart')
            ->logOnly(['barcode', 'sparepart_name', 'merk', 'sparepart_type', 'unit_id', 'estimated_price', 'opname', 'stock', 'hospital_id'])
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
        return "Sparepart " . $this->sparepart_name . " {$eventName} By "  . $user;
    }
}
