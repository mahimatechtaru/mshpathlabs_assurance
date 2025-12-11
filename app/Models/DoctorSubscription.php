<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSubscription extends Model
{
    use HasFactory;

    protected $table = 'doctor_subscription';

    protected $fillable = ['doctor_id', 'subscription_id', 'duration', 'start_date', 'end_date', 'payment_type', 'payment_token', 'amount', 'payment_status', 'status', 'booked_appointment'];

    public function subscription()
    {
        return $this->belongsTo('App\Models\Subscription');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}
