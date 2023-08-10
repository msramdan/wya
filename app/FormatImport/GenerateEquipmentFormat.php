<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\EquipmentCategory;
use App\Models\Vendor;
use App\Models\EquipmentLocation;
use App\Models\Nomenklatur;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Auth;



class GenerateEquipmentFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison, WithTitle
{
    public function title(): string
    {
        return 'Equipment';
    }

    public function view(): View
    {
        return view('equipments.format');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:P1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // set dropdown column
                // $column_b = 'B';
                $column_c = 'C';
                $column_g = 'G';
                $column_h = 'H';
                $column_i = 'I';
                // $column_j = 'J';
                $column_m = 'M';

                // // kolom b category
                // $kolomB = [];
                // $nomenklatur = Nomenklatur::limit(10)->get();
                // foreach ($nomenklatur as $value) {
                //     array_push($kolomB, $value->name_nomenklatur);
                // }
                // $validationB = $event->sheet->getCell("{$column_b}2")->getDataValidation();
                // $validationB->setType(DataValidation::TYPE_LIST);
                // $validationB->setErrorStyle(DataValidation::STYLE_INFORMATION);
                // $validationB->setAllowBlank(false);
                // $validationB->setShowInputMessage(true);
                // $validationB->setShowErrorMessage(true);
                // $validationB->setShowDropDown(true);
                // $validationB->setErrorTitle('Input error');
                // $validationB->setError('Value is not in list.');
                // $validationB->setPromptTitle('Pick from list');
                // $validationB->setPrompt('Please pick a value from the drop-down list.');
                // $validationB->setFormula1(sprintf('"%s"', implode(',', $kolomB)));

                // kolom C category
                $kolomC = [];
                $EquipmentCategory = EquipmentCategory::where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
                foreach ($EquipmentCategory as $value) {
                    array_push($kolomC, $value->category_name);
                }
                $validationC = $event->sheet->getCell("{$column_c}2")->getDataValidation();
                $validationC->setType(DataValidation::TYPE_LIST);
                $validationC->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationC->setAllowBlank(false);
                $validationC->setShowInputMessage(true);
                $validationC->setShowErrorMessage(true);
                $validationC->setShowDropDown(true);
                $validationC->setErrorTitle('Input error');
                $validationC->setError('Value is not in list.');
                $validationC->setPromptTitle('Pick from list');
                $validationC->setPrompt('Please pick a value from the drop-down list.');
                $validationC->setFormula1(sprintf('"%s"', implode(',', $kolomC)));

                // Kolom G Vendor
                $kolomG = [];
                $Vendor = Vendor::where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
                foreach ($Vendor as $value) {
                    array_push($kolomG, $value->name_vendor);
                }
                $validationG = $event->sheet->getCell("{$column_g}2")->getDataValidation();
                $validationG->setType(DataValidation::TYPE_LIST);
                $validationG->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationG->setAllowBlank(false);
                $validationG->setShowInputMessage(true);
                $validationG->setShowErrorMessage(true);
                $validationG->setShowDropDown(true);
                $validationG->setErrorTitle('Input error');
                $validationG->setError('Value is not in list.');
                $validationG->setPromptTitle('Pick from list');
                $validationG->setPrompt('Please pick a value from the drop-down list.');
                $validationG->setFormula1(sprintf('"%s"', implode(',', $kolomG)));

                // Kolom H Condition
                $kolomH = [
                    'Baik',
                    'Tidak Baik',
                ];
                $validationH = $event->sheet->getCell("{$column_h}2")->getDataValidation();
                $validationH->setType(DataValidation::TYPE_LIST);
                $validationH->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationH->setAllowBlank(false);
                $validationH->setShowInputMessage(true);
                $validationH->setShowErrorMessage(true);
                $validationH->setShowDropDown(true);
                $validationH->setErrorTitle('Input error');
                $validationH->setError('Value is not in list.');
                $validationH->setPromptTitle('Pick from list');
                $validationH->setPrompt('Please pick a value from the drop-down list.');
                $validationH->setFormula1(sprintf('"%s"', implode(',', $kolomH)));

                // Kolom I Risk Level
                $kolomI = [
                    'Resiko Rendah',
                    'Resiko Rendah - Sedang',
                    'Resiko Sedang - Tinggi',
                    'Resiko Tinggi',
                ];
                $validationI = $event->sheet->getCell("{$column_i}2")->getDataValidation();
                $validationI->setType(DataValidation::TYPE_LIST);
                $validationI->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationI->setAllowBlank(false);
                $validationI->setShowInputMessage(true);
                $validationI->setShowErrorMessage(true);
                $validationI->setShowDropDown(true);
                $validationI->setErrorTitle('Input error');
                $validationI->setError('Value is not in list.');
                $validationI->setPromptTitle('Pick from list');
                $validationI->setPrompt('Please pick a value from the drop-down list.');
                $validationI->setFormula1(sprintf('"%s"', implode(',', $kolomI)));

                // Kolom J Location
                // $kolomJ = [];
                // $EquipmentLocation = EquipmentLocation::where('hospital_id', Auth::user()->roles->first()->hospital_id)->get();
                // foreach ($EquipmentLocation as $value) {
                //     array_push($kolomJ, $value->location_name);
                // }

                // $validationJ = $event->sheet->getCell("{$column_j}2")->getDataValidation();
                // $validationJ->setType(DataValidation::TYPE_LIST);
                // $validationJ->setErrorStyle(DataValidation::STYLE_INFORMATION);
                // $validationJ->setAllowBlank(false);
                // $validationJ->setShowInputMessage(true);
                // $validationJ->setShowErrorMessage(true);
                // $validationJ->setShowDropDown(true);
                // $validationJ->setErrorTitle('Input error');
                // $validationJ->setError('Value is not in list.');
                // $validationJ->setPromptTitle('Pick from list');
                // $validationJ->setPrompt('Please pick a value from the drop-down list.');
                // $validationJ->setFormula1(sprintf('"%s"', implode(',', $kolomJ)));


                // Kolom M Metode
                $kolomM = [
                    'Garis Lurus',
                    'Saldo Menurun',
                ];
                $validationM = $event->sheet->getCell("{$column_m}2")->getDataValidation();
                $validationM->setType(DataValidation::TYPE_LIST);
                $validationM->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationM->setAllowBlank(false);
                $validationM->setShowInputMessage(true);
                $validationM->setShowErrorMessage(true);
                $validationM->setShowDropDown(true);
                $validationM->setErrorTitle('Input error');
                $validationM->setError('Value is not in list.');
                $validationM->setPromptTitle('Pick from list');
                $validationM->setPrompt('Please pick a value from the drop-down list.');
                $validationM->setFormula1(sprintf('"%s"', implode(',', $kolomM)));

                for ($i = 3; $i <= 1000; $i++) {
                    // $event->sheet->getCell("{$column_b}{$i}")->setDataValidation(clone $validationB);
                    $event->sheet->getCell("{$column_c}{$i}")->setDataValidation(clone $validationC);
                    $event->sheet->getCell("{$column_g}{$i}")->setDataValidation(clone $validationG);
                    $event->sheet->getCell("{$column_h}{$i}")->setDataValidation(clone $validationH);
                    $event->sheet->getCell("{$column_i}{$i}")->setDataValidation(clone $validationI);
                    // $event->sheet->getCell("{$column_j}{$i}")->setDataValidation(clone $validationJ);
                    $event->sheet->getCell("{$column_m}{$i}")->setDataValidation(clone $validationM);
                }
            },
        ];
    }
}
