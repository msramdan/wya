<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['code_vendor', 'name_vendor', 'category_vendor_id', 'email', 'provinsi_id', 'kabkot_id', 'kecamatan_id', 'kelurahan_id', 'zip_kode', 'longitude', 'latitude', 'address'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['code_vendor' => 'string', 'name_vendor' => 'string', 'email' => 'string', 'zip_kode' => 'string', 'longitude' => 'string', 'latitude' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];



    public function category_vendor()
    {
        return $this->belongsTo(\App\Models\CategoryVendor::class);
    }
    public function province()
    {
        return $this->belongsTo(\App\Models\Province::class);
    }
    public function kabkot()
    {
        return $this->belongsTo(\App\Models\Kabkot::class);
    }
    public function kecamatan()
    {
        return $this->belongsTo(\App\Models\Kecamatan::class);
    }
    public function kelurahan()
    {
        return $this->belongsTo(\App\Models\Kelurahan::class);
    }
}
