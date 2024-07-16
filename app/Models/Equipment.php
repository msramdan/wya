<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['barcode', 'nomenklatur_id', 'equipment_category_id', 'manufacturer', 'type', 'serial_number', 'vendor_id', 'condition', 'risk_level', 'equipment_location_id', 'financing_code', 'photo', 'tgl_pembelian', 'metode', 'nilai_perolehan', 'nilai_residu', 'masa_manfaat', 'hospital_id'];

    public function nomenklatur()
    {
        return $this->belongsTo(\App\Models\Nomenklatur::class);
    }
    public function equipment_category()
    {
        return $this->belongsTo(\App\Models\EquipmentCategory::class, 'equipment_category_id');
    }
    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class);
    }
    public function equipment_location()
    {
        return $this->belongsTo(\App\Models\EquipmentLocation::class, 'equipment_location_id');
    }
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_equipment')
            ->logOnly(['barcode', 'nomenklatur_id', 'equipment_category_id', 'manufacturer', 'type', 'serial_number', 'vendor_id', 'condition', 'risk_level', 'equipment_location_id', 'financing_code', 'photo', 'tgl_pembelian', 'metode', 'nilai_perolehan', 'nilai_residu', 'masa_manfaat', 'hospital_id'])
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
        return "Equipment " . $this->barcode . " {$eventName} By "  . $user;
    }
}
