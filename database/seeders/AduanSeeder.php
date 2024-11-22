<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AduanSeeder extends Seeder
{
    public function run()
    {
        DB::table('aduans')->insert([
            [
                'nama' => 'John Doe',
                'email' => 'johndoe@example.com',
                'judul' => 'Bullying di Kelas',
                'keterangan' => 'Laporan mengenai tindakan bullying yang terjadi di kelas X-A.',
                'tanggal' => now(),
                'type' => 'Public',
                'is_read' => 'No',
                'status' => 'Dalam Penanganan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'judul' => 'Tindak Bullying di Lapangan',
                'keterangan' => 'Laporan mengenai insiden bullying yang terjadi saat olahraga.',
                'tanggal' => now(),
                'type' => 'Private',
                'is_read' => 'Yes',
                'status' => 'Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ramdan',
                'email' => 'ramdan@example.com',
                'judul' => 'Tindak Bullying di kantin',
                'keterangan' => 'Laporan mengenai insiden bullying yang terjadi saat di kantin.',
                'tanggal' => now(),
                'type' => 'Private',
                'is_read' => 'Yes',
                'status' => 'Ditolak',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
