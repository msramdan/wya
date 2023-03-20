<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['barcode', 'nomenklatur_id', 'equipment_category_id', 'manufacturer', 'type', 'serial_number', 'vendor_id', 'condition', 'risk_level', 'equipment_location_id', 'financing_code', 'photo'];

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
}
