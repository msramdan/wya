<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Hospital;

class UserAccessHospitalSeeder extends Seeder
{

    public function run()
    {
        $hospitals = Hospital::all();
        foreach ($hospitals as $hospital) {
            DB::table('user_access_hospital')->insert([
                'user_id' => 1,
                'hospital_id' => $hospital->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        DB::table('user_access_hospital')->insert([
            'user_id' => 2,
            'hospital_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
