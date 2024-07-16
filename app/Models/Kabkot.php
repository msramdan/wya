<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Kabkot extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['provinsi_id', 'kabupaten_kota', 'ibukota', 'k_bsni'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['kabupaten_kota' => 'string', 'ibukota' => 'string', 'k_bsni' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function province()
    {
        return $this->belongsTo(\App\Models\Province::class, 'provinsi_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_kota')
            ->logOnly(['provinsi_id', 'kabupaten_kota', 'ibukota','k_bsni'])
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
        return "Kota " . $this->kabupaten_kota . " {$eventName} By "  . $user;
    }

}
