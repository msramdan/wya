<?php

namespace App\Helpers;

class StringHelper
{

    /**
     * Getting arr all alphabetic characters
     *
     * @return array
     */
    public static function getArrAllAlphabet(): array
    {
        return [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        ];
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
