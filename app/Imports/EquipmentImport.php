<?php

namespace App\Imports;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentLocation;
use App\Models\Nomenklatur;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EquipmentImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.barcode' => 'required|min:1|max:100',
            '*.nomenklatur' => 'required|exists:App\Models\Nomenklatur,name_nomenklatur',
            '*.equipment_category' => 'required|exists:App\Models\EquipmentCategory,category_name',
            '*.manufacturer' => 'required|min:1|max:255',
            '*.type' => 'required|min:1|max:255',
            '*.serial_number' => 'required|min:1|max:255',
            '*.vendor' => 'required|exists:App\Models\Vendor,name_vendor',
            '*.condition' => 'required',
            '*.risk_level' => 'required',
            '*.equipment_location' => 'required|exists:App\Models\EquipmentLocation,location_name',
            '*.financing_code' => 'required|min:1|max:255',
        ])->validate();

        foreach ($collection as $row) {
            Equipment::create([
                'barcode' => $row['barcode'],
                'nomenklatur_id' => Nomenklatur::where('name_nomenklatur', $row['nomenklatur'])->first()->id,
                'equipment_category_id' => EquipmentCategory::where('category_name', $row['equipment_category'])->first()->id,
                'manufacturer' => $row['manufacturer'],
                'type' => $row['type'],
                'vendor_id' => Vendor::where('name_vendor', $row['vendor'])->first()->id,
                'condition' => $row['condition'],
                'risk_level' => $row['risk_level'],
                'equipment_location_id' => EquipmentLocation::where('location_name', $row['equipment_location'])->first()->id,
                'financing_code' => $row['financing_code'],
                'serial_number' => $row['serial_number']
            ]);
        }
    }
}
