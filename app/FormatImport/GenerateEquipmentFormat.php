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
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;



class GenerateEquipmentFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    public function view(): View
    {
        return view('equipments.format');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:K1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // set dropdown column
                $column_c = 'C';
                $column_g = 'G';
                $column_h = 'H';
                $column_i = 'I';
                $column_j = 'J';


                // kolom C category
                $kolomC = [];
                $EquipmentCategory = EquipmentCategory::get();
                foreach ($EquipmentCategory as $value) {
                    array_push($kolomC, $value->category_name);
                }
                $validation = $event->sheet->getCell("{$column_c}2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1(sprintf('"%s"', implode(',', $kolomC)));

                // Kolom G Vendor
                $kolomG = [];
                $Vendor = Vendor::get();
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
                $h = [
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
                $validationH->setFormula1(sprintf('"%s"', implode(',', $h)));

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
                $kolomJ = [];
                $EquipmentLocation = EquipmentLocation::get();
                foreach ($EquipmentLocation as $value) {
                    array_push($kolomJ, $value->location_name);
                }

                $validationJ = $event->sheet->getCell("{$column_j}2")->getDataValidation();
                $validationJ->setType(DataValidation::TYPE_LIST);
                $validationJ->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationJ->setAllowBlank(false);
                $validationJ->setShowInputMessage(true);
                $validationJ->setShowErrorMessage(true);
                $validationJ->setShowDropDown(true);
                $validationJ->setErrorTitle('Input error');
                $validationJ->setError('Value is not in list.');
                $validationJ->setPromptTitle('Pick from list');
                $validationJ->setPrompt('Please pick a value from the drop-down list.');
                $validationJ->setFormula1(sprintf('"%s"', implode(',', $kolomJ)));

                for ($i = 3; $i <= 1000; $i++) {
                    $event->sheet->getCell("{$column_c}{$i}")->setDataValidation(clone $validation);
                    $event->sheet->getCell("{$column_g}{$i}")->setDataValidation(clone $validationG);
                    $event->sheet->getCell("{$column_h}{$i}")->setDataValidation(clone $validationH);
                    $event->sheet->getCell("{$column_i}{$i}")->setDataValidation(clone $validationI);
                    $event->sheet->getCell("{$column_j}{$i}")->setDataValidation(clone $validationJ);
                }
            },
        ];
    }
}