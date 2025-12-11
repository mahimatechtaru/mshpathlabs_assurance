<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';

    protected $fillable = ['user_id', 'appointment_id', 'hospital_id', 'doctor_id', 'cancel_by', 'cancel_reason', 'payment_status', 'amount', 'payment_type', 'appointment_for', 'patient_name', 'age', 'report_image', 'drug_effect', 'patient_address', 'phone_no', 'date', 'time', 'payment_token', 'appointment_status', 'illness_information', 'note', 'doctor_commission', 'admin_commission', 'discount_id', 'discount_price', 'is_from', 'is_insured', 'policy_insurer_name', 'policy_number', 'scheduled_notification_id_doctor', 'scheduled_notification_id_patient'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }

    public function doctorUser()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,       // The model we ultimately want (User)
            \App\Models\Doctor::class,     // The model in between (Doctor)
            'id',                          // Doctor's primary key (id)
            'id',                          // User's primary key (id)
            'doctor_id',                   // Appointment's foreign key to Doctor (doctor_id)
            'user_id'                      // Doctor's foreign key to User (user_id)
        );
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Models\Hospital');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\UserAddress', 'patient_address', 'id');
    }

    protected $appends = ['rate', 'review'];

    public function getreportImageAttribute()
    {
        if (isset($this->attributes['report_image']) && $this->attributes['report_image'] != null) {
            $images = [];
            $image = json_decode($this->attributes['report_image']);

            for ($i = 0; $i < count($image); $i++) {
                array_push($images, url('images/upload').'/'.$image[$i]);
            }

            return $images;
        } else {
            return [];
        }

    }

    public function getRateAttribute()
    {
        $review = Review::where('appointment_id', $this->attributes['id'])->get();
        if (count($review) > 0) {
            $totalRate = 0;
            foreach ($review as $r) {
                $totalRate = $totalRate + $r->rate;
            }

            return round($totalRate / count($review), 1);
        } else {
            return 0;
        }
    }

    public function getReviewAttribute()
    {
        return Review::where('appointment_id', $this->attributes['id'])->count();
    }
}
