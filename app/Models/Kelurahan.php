<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;


class Kelurahan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['kecamatan_id', 'kelurahan', 'kd_pos'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['kelurahan' => 'string', 'kd_pos' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];



	public function kecamatan()
	{
		return $this->belongsTo(\App\Models\Kecamatan::class);
	}

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('lod_kelurahan')
            ->logOnly(['kecamatan_id', 'kelurahan', 'kd_pos'])
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
        return "Kelurahan " . $this->kelurahan . " {$eventName} By "  . $user;
    }
}
