<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProcess extends Model
{
    use HasFactory;

    protected $fillable = ['work_order_id', 'schedule_date', 'start_date', 'end_date', 'schedule_wo', 'status'];
}
