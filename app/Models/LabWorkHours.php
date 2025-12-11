<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabWorkHours extends Model
{
    use HasFactory;

    protected $table = 'lab_working_hours';

    protected $fillable = ['lab_id', 'day_index', 'period_list', 'status'];
}
