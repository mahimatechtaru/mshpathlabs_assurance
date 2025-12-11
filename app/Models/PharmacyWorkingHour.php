<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyWorkingHour extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_working_hour';

    protected $fillable = ['pharmacy_id', 'day_index', 'period_list', 'status'];
}
