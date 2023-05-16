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
            'phone' => '6283874731480',
            'address' => "Perumahan SAI Residance",
            'logo' => 'logo.png',
        ]);
    }
}
