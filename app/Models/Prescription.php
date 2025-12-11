<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescription';

    protected $fillable = ['appointment_id', 'medicines', 'doctor_id', 'user_id', 'pdf'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment');
    }
}
