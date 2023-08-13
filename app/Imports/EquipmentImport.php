<?php

namespace App\Imports;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentLocation;
use App\Models\Nomenklatur;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Auth;
use DateTime;

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
            '*.code_nomenklatur' => 'required|exists:App\Models\Nomenklatur,code_nomenklatur',
            '*.equipment_category' => 'required|exists:App\Models\EquipmentCategory,category_name',
            '*.manufacturer' => 'required|min:1|max:255',
            '*.type' => 'required|min:1|max:255',
            '*.serial_number' => 'required|min:1|max:255',
            '*.vendor' => 'required|exists:App\Models\Vendor,name_vendor',
            '*.condition' => 'required',
            '*.risk_level' => 'required',
            '*.code_location' => 'required',
            '*.financing_code' => 'required|min:1|max:255',
            '*.tanggal_pembelian' => 'required',
            '*.metode_penyusutan' => 'required|in:Garis Lurus,Saldo Menurun',
            '*.nilai_perolehan' => 'required|numeric',
            '*.nilai_residu' => 'required|numeric',
            '*.masa_manfaat' => 'required|numeric'
        ])->validate();

        foreach ($collection as $row) {
            Equipment::create([
                'barcode' => $row['barcode'],
                'nomenklatur_id' => Nomenklatur::where('code_nomenklatur', $row['code_nomenklatur'])->first()->id,
                'equipment_category_id' => EquipmentCategory::where('category_name', $row['equipment_category'])->first()->id,
                'manufacturer' => $row['manufacturer'],
                'type' => $row['type'],
                'vendor_id' => Vendor::where('name_vendor', $row['vendor'])->first()->id,
                'condition' => $row['condition'],
                'risk_level' => $row['risk_level'],
                'equipment_location_id' => EquipmentLocation::where('code_location', $row['code_location'])->first()->id,
                'financing_code' => $row['financing_code'],
                'serial_number' => $row['serial_number'],
                'tgl_pembelian' => self::convertTglFromExcel($row['tanggal_pembelian']),
                'metode' => $row['metode_penyusutan'],
                'nilai_perolehan' => $row['nilai_perolehan'],
                'nilai_residu' => $row['nilai_residu'],
                'masa_manfaat' => $row['masa_manfaat'],
                'hospital_id' => Auth::user()->roles->first()->hospital_id,
            ]);
        }
    }

    public static function convertTglFromExcel($num) {
            $excel_date = $num; //here is that value 41621 or 41631
            $unix_date = ($excel_date - 25569) * 86400;
            $excel_date = 25569 + ($unix_date / 86400);
            $unix_date = ($excel_date - 25569) * 86400;
            return gmdate("Y-m-d", $unix_date);
    }
}
