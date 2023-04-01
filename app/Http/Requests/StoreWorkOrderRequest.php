<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkOrderRequest extends FormRequest
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
            'start_date' => 'required_if:category_wo,Rutin|date|nullable',
            'end_date' => 'required_if:category_wo,Rutin|date|nullable',
            'schedule_wo' => 'required_if:category_wo,Rutin|in:Harian,Mingguan,Bulanan,2 Bulanan,3 Bulanan,4 Bulanan,6 Bulanan,Tahunan|nullable',
        ];
    }
}
