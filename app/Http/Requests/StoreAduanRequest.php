<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAduanRequest extends FormRequest
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
            'nama' => 'required|string',
			'email' => 'required|email|unique:aduans,email',
			'judul' => 'required|string',
			'keterangan' => 'required|string',
			'tanggal' => 'required',
			'type' => 'required|in:Public,Private',
			'is_read' => 'required|in:Yes,No',
        ];
    }
}
