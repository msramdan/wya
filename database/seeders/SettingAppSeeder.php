<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SettingApp;

class SettingAppSeeder extends Seeder
{
    public function run()
    {
        SettingApp::create([
            'aplication_name' => 'Marsweb Application',
            'logo' => '',
            'favicon' => '',
            'phone' => '083874731480',
            'email' => 'saepulramdan244@gmail.com',
            'address' => 'Graha Mas Fatmawati Blok A 36 Jl RS Fatmawati Gedung Informa Fatmawati , Samping ITC Fatmawati',
            'notif_wa' => 1,
            'paper_qr_code' => '68.0315',
            'url_wa_gateway' => 'http://103.176.79.206:40000',
            'session_wa_gateway' => 'apps_marsweb',
            'bot_telegram' => 1,
        ]);
    }
}
