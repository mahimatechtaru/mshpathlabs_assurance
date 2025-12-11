<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabSettle extends Model
{
    use HasFactory;

    protected $table = 'lab_settle';

    protected $fillable = ['lab_id', 'report_id', 'admin_amount', 'lab_amount', 'payment', 'lab_status'];
}
