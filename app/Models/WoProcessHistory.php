<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoProcessHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'wo_process_id', 'status_wo_process', 'date_time', 'updated_by'
    ];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
