<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparepartIn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['qty_stok_in', 'no_referensi', 'note', 'user_id','sparepart_id'];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
