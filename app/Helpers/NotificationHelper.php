<?php

namespace App\Helpers;

use App\Models\SettingApp;
use Illuminate\Support\Facades\Http;

class NotificationHelper
{

    public static function notifWhatsapp($receiver, $message)
    {
        $settingApp = SettingApp::first();

        Http::post($settingApp['url_wa_gateway'] . '/chats/send?id=' . $settingApp['session_wa_gateway'], [
            'receiver' => $receiver,
            'message' => [
                'text' => $message
            ]
        ]);
    }
}
