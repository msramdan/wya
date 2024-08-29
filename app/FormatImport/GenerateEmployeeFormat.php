<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\EmployeeType;
use App\Models\Department;
use App\Models\Position;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Auth;



class GenerateEmployeeFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    public function view(): View
    {
        return view('employees.format');
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

                // Kolom C Type
                $drop_column = 'C';
                $options = [];
                $dataUnit = EmployeeType::where('hospital_id', session('sessionHospital'))->get();
                foreach ($dataUnit as $value) {
                    array_push($options, $value->name_employee_type);
                }
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
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
                $validation->setFormula1(sprintf('"%s"', implode(',', $options)));

                // kolom D Employee Status
                $kolom_d = 'D';
                $kolomD = [
                    'Aktif',
                    'Non Aktif',
                ];
                $validationD = $event->sheet->getCell("{$kolom_d}2")->getDataValidation();
                $validationD->setType(DataValidation::TYPE_LIST);
                $validationD->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationD->setAllowBlank(false);
                $validationD->setShowInputMessage(true);
                $validationD->setShowErrorMessage(true);
                $validationD->setShowDropDown(true);
                $validationD->setErrorTitle('Input error');
                $validationD->setError('Value is not in list.');
                $validationD->setPromptTitle('Pick from list');
                $validationD->setPrompt('Please pick a value from the drop-down list.');
                $validationD->setFormula1(sprintf('"%s"', implode(',', $kolomD)));

                // kolom E Departemen
                $kolom_e = 'E';
                $kolomE = [];
                $dataDepartemen = Department::where('hospital_id', session('sessionHospital'))->get();
                foreach ($dataDepartemen as $value) {
                    array_push($kolomE, $value->name_department);
                }
                $validationE = $event->sheet->getCell("{$kolom_e}2")->getDataValidation();
                $validationE->setType(DataValidation::TYPE_LIST);
                $validationE->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationE->setAllowBlank(false);
                $validationE->setShowInputMessage(true);
                $validationE->setShowErrorMessage(true);
                $validationE->setShowDropDown(true);
                $validationE->setErrorTitle('Input error');
                $validationE->setError('Value is not in list.');
                $validationE->setPromptTitle('Pick from list');
                $validationE->setPrompt('Please pick a value from the drop-down list.');
                $validationE->setFormula1(sprintf('"%s"', implode(',', $kolomE)));


                // kolom F Posotion
                $kolom_f = 'F';
                $kolomF = [];
                $dataPosition = Position::where('hospital_id', session('sessionHospital'))->get();
                foreach ($dataPosition as $value) {
                    array_push($kolomF, $value->name_position);
                }
                $validationF = $event->sheet->getCell("{$kolom_f}2")->getDataValidation();
                $validationF->setType(DataValidation::TYPE_LIST);
                $validationF->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationF->setAllowBlank(false);
                $validationF->setShowInputMessage(true);
                $validationF->setShowErrorMessage(true);
                $validationF->setShowDropDown(true);
                $validationF->setErrorTitle('Input error');
                $validationF->setError('Value is not in list.');
                $validationF->setPromptTitle('Pick from list');
                $validationF->setPrompt('Please pick a value from the drop-down list.');
                $validationF->setFormula1(sprintf('"%s"', implode(',', $kolomF)));

                for ($i = 3; $i <= 1000; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    $event->sheet->getCell("{$kolom_d}{$i}")->setDataValidation(clone $validationD);
                    $event->sheet->getCell("{$kolom_e}{$i}")->setDataValidation(clone $validationE);
                    $event->sheet->getCell("{$kolom_f}{$i}")->setDataValidation(clone $validationF);
                }
            },
        ];
    }
}
