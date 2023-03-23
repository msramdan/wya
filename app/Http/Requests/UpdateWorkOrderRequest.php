<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
			'type_wo' => 'required|boolean',
			'filed_date' => 'required|date',
			'category_wo' => 'required|boolean',
			'schedule_date' => 'required|date',
			'note' => 'required|string',
			'created_by' => 'required|exists:App\Models\User,id',
			'status_wo' => 'required|boolean',
        ];
    }
}
