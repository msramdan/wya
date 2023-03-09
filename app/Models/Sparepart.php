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
    protected $fillable = ['barcode', 'sparepart_name', 'merk', 'sparepart_type', 'unit_id', 'estimated_price', 'stock'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['barcode' => 'string', 'sparepart_name' => 'string', 'merk' => 'string', 'sparepart_type' => 'string', 'estimated_price' => 'integer', 'stock' => 'integer', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];



    public function unit_item()
    {
        return $this->belongsTo(\App\Models\UnitItem::class, 'unit_id');
    }
}
