<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['code_position', 'name_position', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['code_position' => 'string', 'name_position' => 'string', 'is_active' => 'boolean'];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }
}
