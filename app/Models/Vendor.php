<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class Vendor extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['code_vendor', 'name_vendor', 'category_vendor_id', 'email', 'provinsi_id', 'kabkot_id', 'kecamatan_id', 'kelurahan_id', 'zip_kode', 'longitude', 'latitude', 'address', 'hospital_id'];

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
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_vendor')
            ->logOnly(['code_vendor', 'name_vendor', 'category_vendor_id', 'email', 'provinsi_id', 'kabkot_id', 'kecamatan_id', 'kelurahan_id', 'zip_kode', 'longitude', 'latitude', 'address', 'hospital_id'])
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
        return "Vendor " . $this->name_vendor . " {$eventName} By "  . $user;
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            $lastLog = Activity::where('log_name', 'log_vendor')
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
