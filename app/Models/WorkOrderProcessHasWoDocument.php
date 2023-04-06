<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProcessHasWoDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_process_id',
        'document_name',
        'description',
        'file'
    ];
}
