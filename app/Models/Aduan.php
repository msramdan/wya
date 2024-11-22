<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'email', 'judul', 'keterangan', 'tanggal', 'type', 'is_read','status'];
}
