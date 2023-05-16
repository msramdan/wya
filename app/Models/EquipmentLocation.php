<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['code_location', 'location_name', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['code_location' => 'string', 'location_name' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }
}
