<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
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
            'no_peminjaman' => 'required|string|max:100',
			'equipment_id' => 'required|exists:App\Models\Equipment,id',
			'hospital_id' => 'required|exists:App\Models\Hospital,id',
			'lokasi_asal_id' => 'required|exists:App\Models\EquipmentLocation,id',
			'lokasi_peminjam_id' => 'required|exists:App\Models\EquipmentLocation,id',
			'waktu_pinjam' => 'required',
			'waktu_dikembalikan' => 'nullable',
			'alasan_peminjaman' => 'required|string',
			'status_peminjaman' => 'required|in:Sudah dikembalikan,Belum dikembalikan',
			'catatan_pengembalian' => 'nullable|string',
			'pic_penanggungjawab' => 'required|string|max:255',
			'bukti_peminjaman' => 'required|image|max:3000',
			'bukti_pengembalian' => 'nullable|image|max:3000',
			'user_created' => 'required|exists:App\Models\User,id',
			'user_updated' => 'nullable|exists:App\Models\User,id',
        ];
    }
}
