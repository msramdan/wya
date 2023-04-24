<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\Nomenklatur;

class NomenklaturImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            Nomenklatur::create([
                'code_nomenklatur' => $row['code_nomenklatur'],
                'name_nomenklatur' => $row['name_nomenklatur'],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
