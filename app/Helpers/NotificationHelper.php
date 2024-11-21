<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use App\Models\Hospital;

class NotificationHelper
{

    public static function notifWhatsapp($receiver, $message, $hospital_id)
    {
        $settingApp = Hospital::findOrFail($hospital_id);
        Http::post($settingApp['url_wa_gateway'] . '/send-message', [
            'api_key' => $settingApp['api_key_wa_gateway'],
            'receiver' => $receiver,
            'data' => [
                'message' => $message
            ]
        ]);
    }
}
