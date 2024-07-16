<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class SettingApp extends Model
{
    use HasFactory;
    use LogsActivity;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['aplication_name', 'logo', 'favicon', 'phone', 'email', 'address', 'url_wa_gateway', 'notif_wa', 'api_key_wa_gateway', 'bot_telegram', 'paper_qr_code', 'work_order_has_access_approval_users_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('log_setting')
            ->logOnly(['aplication_name', 'logo', 'favicon', 'phone', 'email', 'address', 'url_wa_gateway', 'notif_wa', 'api_key_wa_gateway', 'bot_telegram', 'paper_qr_code', 'work_order_has_access_approval_users_id'])
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
        return "Setting " . $this->aplication_name . " {$eventName} By "  . $user;
    }
}
