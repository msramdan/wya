<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class UnitItem extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['code_unit', 'unit_name', 'hospital_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['code_unit' => 'string', 'unit_name' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];

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
        if (isset(Auth::user()->name)) {
            $user = Auth::user()->name;
        } else {
            $user = "Super Admin";
        }
        return "Unit item " . $this->unit_name . " {$eventName} By "  . $user;
    }
}
