<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'nid_employee', 'employee_type_id', 'employee_status', 'departement_id', 'position_id', 'email', 'phone', 'provinsi_id', 'kabkot_id', 'kecamatan_id', 'kelurahan_id', 'zip_kode', 'address', 'longitude', 'latitude', 'join_date', 'photo', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['join_date' => 'date:d/m/Y', 'photo' => 'string'];



    public function employee_type()
    {
        return $this->belongsTo(\App\Models\EmployeeType::class);
    }
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class, 'departement_id');
    }

    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
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
            ->useLogName('log_employee')
            ->logOnly(['name', 'nid_employee', 'employee_type_id', 'employee_status', 'departement_id', 'position_id', 'email', 'phone', 'provinsi_id', 'kabkot_id', 'kecamatan_id', 'kelurahan_id', 'zip_kode', 'address', 'longitude', 'latitude', 'join_date', 'photo', 'hospital_id'])
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
        return "Employee " . $this->name . " {$eventName} By "  . $user;
    }
}
