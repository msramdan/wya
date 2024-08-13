<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


class Loan extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['no_peminjaman', 'equipment_id', 'hospital_id', 'lokasi_asal_id', 'lokasi_peminjam_id', 'waktu_pinjam', 'waktu_dikembalikan', 'alasan_peminjaman', 'status_peminjaman', 'catatan_pengembalian', 'pic_penanggungjawab', 'bukti_pengembalian', 'user_created', 'user_updated'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['no_peminjaman' => 'string', 'waktu_pinjam' => 'datetime:d/m/Y H:i', 'waktu_dikembalikan' => 'datetime:d/m/Y H:i', 'alasan_peminjaman' => 'string', 'catatan_pengembalian' => 'string', 'pic_penanggungjawab' => 'string','bukti_pengembalian' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];



    public function equipment()
    {
        return $this->belongsTo(\App\Models\Equipment::class);
    }
    public function hospital()
    {
        return $this->belongsTo(\App\Models\Hospital::class);
    }
    public function equipment_location()
    {
        return $this->belongsTo(\App\Models\EquipmentLocation::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_loan')
            ->logOnly(['no_peminjaman', 'equipment_id', 'hospital_id', 'lokasi_asal_id', 'lokasi_peminjam_id', 'waktu_pinjam', 'waktu_dikembalikan', 'alasan_peminjaman', 'status_peminjaman', 'catatan_pengembalian', 'pic_penanggungjawab', 'bukti_pengembalian', 'user_created', 'user_updated'])
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
        return "Loan " . $this->no_peminjaman . " {$eventName} By "  . $user;
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            $lastLog = Activity::where('log_name', 'log_loan')
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
