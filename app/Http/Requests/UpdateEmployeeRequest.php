<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:200',
			'nid_employee' => 'required|string|min:1|max:50',
			'employee_type_id' => 'required|exists:App\Models\EmployeeType,id',
			'employee_status' => 'required|boolean',
			'departement_id' => 'required|exists:App\Models\Department,id',
			'position_id' => 'required|exists:App\Models\Position,id',
			'email' => 'required|string|min:1|max:100',
			'phone' => 'required|string|min:1|max:15',
			'provinsi_id' => 'required|exists:App\Models\Province,id',
			'kabkot_id' => 'required|exists:App\Models\Kabkot,id',
			'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
			'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
			'zip_kode' => 'required|string|min:1|max:10',
			'address' => 'required|string',
			'longitude' => 'required|string|min:1|max:200',
			'latitude' => 'required|string|min:1|max:200',
			'join_date' => 'required|date',
			'photo' => 'required',
        ];
    }
}
