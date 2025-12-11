<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $fillable = ['review', 'rate', 'user_id', 'appointment_id', 'doctor_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id', 'id');
    }
}
