<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateWorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'equipment_id' => 'required|exists:App\Models\Equipment,id',
            'type_wo' => 'required|in:Calibration,Service,Training,Inspection and Preventive Maintenance',
            'filed_date' => 'required|date',
            'category_wo' => 'required|in:Rutin,Non Rutin',
            'note' => 'required|string',
            'schedule_date' => 'required_if:category_wo,Non Rutin|nullable',
            'start_date' => 'required_if:category_wo,Rutin|date|nullable|before_or_equal:end_date',
            'schedule_wo' => 'required_if:category_wo,Rutin|in:Harian,Mingguan,Bulanan,2 Bulanan,3 Bulanan,4 Bulanan,6 Bulanan,Tahunan|nullable',
            'end_date' => ['required_if:category_wo,Rutin', 'date', 'nullable', 'after_or_equal:start_date', function ($attribute, $value, $fail) {
                if (request()->get('category_wo') == 'Rutin') {
                    $startDateValue = request()->get('start_date');
                    $endDateValue = request()->get('end_date');
                    $scheduleWoValue = request()->get('schedule_wo');
                    $scheduleWoFormatted = '';
                    $stepModeAmount = 1;
                    $counter = 1;
                    $workOrderSchedules = [];

                    if ($startDateValue && $endDateValue && $scheduleWoValue) {
                        switch ($scheduleWoValue) {
                            case 'Harian':
                                $scheduleWoFormatted = 'days';
                                break;
                            case 'Mingguan':
                                $scheduleWoFormatted = 'weeks';
                                break;
                            case 'Bulanan':
                                $scheduleWoFormatted = 'months';
                                break;
                            case '2 Bulanan':
                                $stepModeAmount = 2;
                                $scheduleWoFormatted = 'months';
                                break;
                            case '3 Bulanan':
                                $stepModeAmount = 3;
                                $scheduleWoFormatted = 'months';
                                break;
                            case '4 Bulanan':
                                $stepModeAmount = 4;
                                $scheduleWoFormatted = 'months';
                                break;
                            case '6 Bulanan':
                                $stepModeAmount = 6;
                                $scheduleWoFormatted = 'months';
                                break;
                            case 'Tahunan':
                                $scheduleWoFormatted = 'years';
                                break;
                        }

                        while ($startDateValue <= $endDateValue) {
                            $tempEndData = Carbon::createFromFormat('Y-m-d', $startDateValue)->add($stepModeAmount, $scheduleWoFormatted)->format('Y-m-d');

                            if (Carbon::createFromFormat('Y-m-d', $tempEndData)->subDay()->format('Y-m-d') <= $endDateValue) {
                                $workOrderSchedules[] = [
                                    'id' => 'Schedule ' . $counter,
                                    'name' => 'Schedule Rutin ' . $counter,
                                    'start' => $startDateValue,
                                    'end' => Carbon::createFromFormat('Y-m-d', $tempEndData)->subDay()->format('Y-m-d'),
                                    'progress' => 100,
                                ];
                            }

                            $startDateValue = $tempEndData;
                            $counter++;
                        }

                        if (count($workOrderSchedules) == 0) {
                            return $fail('Schedule is not match');
                        }
                    }
                }
            }]
        ];
    }
}
