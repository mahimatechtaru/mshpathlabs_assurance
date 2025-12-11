<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctor';

    protected $fillable = ['name', 'is_filled', 'treatment_id', 'category_id', 'custom_timeslot', 'dob', 'gender', 'expertise_id', 'timeslot', 'start_time', 'end_time', 'hospital_id', 'image', 'user_id', 'desc', 'education', 'certificate', 'appointment_fees', 'experience', 'since', 'status', 'based_on', 'commission_amount', 'is_popular', 'subscription_status', 'language'];

    protected $appends = ['fullImage', 'rate', 'review'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function expertise()
    {
        return $this->belongsTo('App\Models\Expertise');
    }

    public function treatment()
    {
        return $this->belongsTo('App\Models\Treatments');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function DoctorSubscription()
    {
        return $this->hasOne('App\Models\DoctorSubscription');
    }

    public function Doctor()
    {
        return $this->hasOne('App\Models\Doctor');
    }

    public function getRateAttribute()
    {
        $review = Review::where('doctor_id', $this->attributes['id'])->get();
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
        return Review::where('doctor_id', $this->attributes['id'])->count();
    }
}
