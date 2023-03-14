<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
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
            'barcode' => 'required|string|min:1|max:100',
			'nomenklatur_id' => 'required|exists:App\Models\Nomenklatur,id',
			'equipment_category_id' => 'required|exists:App\Models\EquipmentCategory,id',
			'manufacturer' => 'required|string|min:1|max:255',
			'type' => 'required|string|min:1|max:255',
			'serial_number' => 'required|string|min:1|max:255',
			'vendor_id' => 'required|exists:App\Models\Vendor,id',
			'condition' => 'required|boolean',
			'risk_level' => 'required|boolean',
			'equipment_location_id' => 'required|exists:App\Models\EquipmentLocation,id',
			'financing_code' => 'required|string|min:1|max:255',
			'photo' => 'required|string|min:1|max:255',
        ];
    }
}
