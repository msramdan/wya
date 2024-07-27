<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class UnitItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['code_unit', 'unit_name', 'hospital_id'];

    protected $casts = [
        'code_unit' => 'string',
        'unit_name' => 'string',
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i'
    ];

    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_unit_item')
            ->logOnly(['code_unit', 'unit_name', 'hospital_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $user = Auth::user()->name ?? "Super Admin";
        return "Unit item " . $this->unit_name . " {$eventName} By "  . $user;
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            $lastLog = Activity::where('log_name', 'log_unit_item')
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
