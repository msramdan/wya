<?php

namespace Database\Seeders;

use App\Models\UnitItem;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnitItem::create([
            'code_unit' => 'Kg',
            'unit_name' => 'Kilogram',
            'hospital_id' => 1,
        ]);
    }
}
