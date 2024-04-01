<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalRequest extends FormRequest
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
            'name' => 'required|string|min:5|max:200',
            'phone' => 'required|string|min:10|max:15',
            'email' => 'required|string|min:5|max:150',
            'address' => 'required|string|min:5|max:255',
            'logo' => 'required|image|max:3024',
            'notif_wa' => 'required|boolean',
            'url_wa_gateway' => 'required|string|min:1|max:150',
            'api_key_wa_gateway' => 'required|string|min:1|max:150',
            'paper_qr_code' => 'required',
            'bot_telegram' => 'required|boolean',
            // 'work_order_has_access_approval_users_id' => 'required',
        ];
    }
}
