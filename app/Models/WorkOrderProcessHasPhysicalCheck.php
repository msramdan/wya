<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProcessHasPhysicalCheck extends Model
{
    use HasFactory;

    protected $fillable = ['physical_check', 'physical_health', 'physical_cleanliness'];
}
