<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;

class VendorsExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        $vendors = DB::table('vendors')
            ->join('category_vendors', 'vendors.category_vendor_id', '=', 'category_vendors.id')
            ->join('provinces', 'vendors.provinsi_id', '=', 'provinces.id')
            ->join('kabkots', 'vendors.kabkot_id', '=', 'kabkots.id')
            ->join('kecamatans', 'vendors.kecamatan_id', '=', 'kecamatans.id')
            ->join('kelurahans', 'vendors.kelurahan_id', '=', 'kelurahans.id')
            ->select('vendors.*', 'category_vendors.name_category_vendors', 'provinces.provinsi', 'kabkots.kabupaten_kota', 'kecamatans.kecamatan', 'kelurahans.kelurahan')->orderBy('vendors.id', 'desc')->get();
        return view('vendors.export', [
            'data' => $vendors
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:J1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
