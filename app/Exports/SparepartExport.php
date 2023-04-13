<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Nomenklatur;
use Illuminate\Support\Facades\DB;

class SparepartExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        $data =
            DB::table('spareparts')
            ->join('unit_items', 'spareparts.unit_id', '=', 'unit_items.id')
            ->select('spareparts.*', 'unit_items.unit_name')->orderBy('spareparts.id', 'desc')->get();
        return view('spareparts.export', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:G1'; // All headers
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
