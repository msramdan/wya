<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class CategoryVendor extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name_category_vendors', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name_category_vendors' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_category_vendor')
            ->logOnly(['name_category_vendors', 'hospital_id'])
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
        return "Category vendor " . $this->name_category_vendors . " {$eventName} By "  . $user;
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            $lastLog = Activity::where('log_name', 'log_category_vendor')
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
