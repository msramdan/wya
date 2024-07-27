<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class EquipmentCategory extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['code_categoty', 'category_name', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['code_categoty' => 'string', 'category_name' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_equipment_category')
            ->logOnly(['code_categoty', 'category_name', 'hospital_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if (isset(Auth::user()->name)) {
            $user = Auth::user()->name;
        } else {
            $user = "Super Admin";
        }
        return "Equipment category " . $this->category_name . " {$eventName} By "  . $user;
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            $lastLog = Activity::where('log_name', 'log_equipment_category')
                ->where('subject_id', $model->id)
                ->where('subject_type', get_class($model))
                ->latest()
                ->first();

            if ($lastLog) {
                $lastLog->hospital_id = $model->hospital_id;
                $lastLog->save();
            }
        });
    }
}
