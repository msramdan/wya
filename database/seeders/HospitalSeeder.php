<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospital::create([
            'name' => 'RS Bogor',
            'phone' => '083874731480',
            'email' => 'saepulramdan244@gmail.com',
            'address' => 'Graha Mas Fatmawati Blok A 36 Jl RS Fatmawati Gedung Informa Fatmawati , Samping ITC Fatmawati',
            'notif_wa' => 1,
            'url_wa_gateway' => 'https://wagw.easytopup.my.id/api',
            'session_wa_gateway' => 'apps_marsweb',
            'paper_qr_code' => '68.0315',
            'bot_telegram' => 1,
            'logo' => '',
        ]);
        Hospital::create([
            'name' => 'RS Citra Husada',
            'phone' => '085155353793',
            'email' => 'muzayyin654@gmail.com',
            'address' => 'Gadu Barat Ganding Sumenep',
            'notif_wa' => 1,
            'url_wa_gateway' => 'https://wagw.easytopup.my.id/api',
            'session_wa_gateway' => 'apps_marsweb',
            'paper_qr_code' => '68.0315',
            'bot_telegram' => 1,
            'logo' => '',
        ]);
    }
}
