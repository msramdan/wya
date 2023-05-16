<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitItemRequest extends FormRequest
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
            'code_unit' => 'required|string|min:1|max:20',
            'unit_name' => 'required|string|min:1|max:200',
            'hospital_id' => 'required|exists:App\Models\Hospital,id',
        ];
    }
}
