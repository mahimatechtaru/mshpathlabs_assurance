<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settle extends Model
{
    use HasFactory;

    protected $table = 'settle';

    protected $fillable = ['appointment_id', 'doctor_id', 'doctor_amount', 'admin_amount', 'payment', 'doctor_status'];
}
