<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
            'code_vendor' => 'required|string|min:1|max:20',
			'name_vendor' => 'required|string|min:1|max:200',
			'category_vendor_id' => 'required|exists:App\Models\CategoryVendor,id',
			'email' => 'required|string|min:1|max:100',
			'provinsi_id' => 'required|exists:App\Models\Province,id',
			'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
			'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
			'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
			'zip_kode' => 'required|string|min:1|max:5',
			'longitude' => 'required|string|min:1|max:100',
			'latitude' => 'required|string|min:1|max:100',
        ];
    }
}
