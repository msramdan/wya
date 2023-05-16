<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

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
}