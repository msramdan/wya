<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;


class Kecamatan extends Model
{
    use HasFactory;
    use LogsActivity;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['kabkot_id', 'kecamatan'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['kecamatan' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];



	public function kabkot()
	{
		return $this->belongsTo(\App\Models\Kabkot::class);
	}

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_kecamatan')
            ->logOnly(['kabkot_id', 'kecamatan'])
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
        return "Kecamatan " . $this->kecamatan . " {$eventName} By "  . $user;
    }
}
