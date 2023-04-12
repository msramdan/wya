<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;


class EmployeeExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        $data = DB::table('employees')
            ->join('employee_types', 'employees.employee_type_id', '=', 'employee_types.id')
            ->join('provinces', 'employees.provinsi_id', '=', 'provinces.id')
            ->join('kabkots', 'employees.kabkot_id', '=', 'kabkots.id')
            ->join('kecamatans', 'employees.kecamatan_id', '=', 'kecamatans.id')
            ->join('kelurahans', 'employees.kelurahan_id', '=', 'kelurahans.id')
            ->select('employees.*', 'employee_types.name_employee_type', 'provinces.provinsi', 'kabkots.kabupaten_kota', 'kecamatans.kecamatan', 'kelurahans.kelurahan')->orderBy('employees.id', 'desc')->get();
        return view('employees.export', [
            'data' => $data
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
