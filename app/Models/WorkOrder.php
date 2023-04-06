<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['equipment_id', 'type_wo', 'filed_date', 'category_wo', 'schedule_date', 'note', 'created_by', 'status_wo', 'wo_number', 'approval_users_id', 'start_date', 'end_date', 'schedule_wo', 'approved_at'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['filed_date' => 'date:d/m/Y', 'schedule_date' => 'date:d/m/Y', 'note' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function equipment()
    {
        return $this->belongsTo(\App\Models\Equipment::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    public function countWoProcess($status = null)
    {
        return WorkOrderProcess::where('work_order_id', $this->id)->when($status, function ($query, $status) {
            $query->where('status', $status);
        })->count();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
