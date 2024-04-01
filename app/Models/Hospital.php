<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'phone', 'email', 'address', 'logo', 'notif_wa', 'url_wa_gateway', 'api_key_wa_gateway', 'paper_qr_code', 'bot_telegram', 'work_order_has_access_approval_users_id'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['name' => 'string', 'phone' => 'string', 'email' => 'string', 'address' => 'string', 'logo' => 'string', 'notif_wa' => 'boolean', 'url_wa_gateway' => 'string', 'api_key_wa_gateway' => 'string', 'bot_telegram' => 'boolean', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}
