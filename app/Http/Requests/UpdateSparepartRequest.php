<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSparepartRequest extends FormRequest
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
            'barcode' => 'required|string|min:1|max:200',
			'sparepart_name' => 'required|string|min:1|max:200',
			'merk' => 'required|string|min:1|max:200',
			'sparepart_type' => 'required|string|min:1|max:200',
			'unit_id' => 'required|exists:App\Models\UnitItem,id',
			'estimated_price' => 'required|numeric',
			'stock' => 'nullable',
        ];
    }
}
