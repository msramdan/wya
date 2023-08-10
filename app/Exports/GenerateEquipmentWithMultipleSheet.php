<?php

namespace App\Exports;

use App\FormatImport\GenerateEquipmentFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GenerateEquipmentWithMultipleSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new GenerateEquipmentFormat(),
            1 => new NomenklaturExport(),
            2 => new LocationExport()
        ];
    }
}
