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

    function storeMessage($dataTiket, $devEUI, $instanceName, $time, $clusterName)
    {

        $text = "Alert from device 374ebd9100360047\n"
            . "<b>Description: </b>\n\n"
            . "dsadad\n\n"
            . "<b>Date: </b>\n";

        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
    }
}
