<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory,HasRoles,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_code',
        'image',
        'verify',
        'otp',
        'dob',
        'gender',
        'image',
        'doctor_id',
        'status',
        'device_token',
        'language',
        'channel_name',
        'agora_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function User()
    {
        return $this->hasOne('App\Models\User');
    }

    public function zoomOAuth()
    {
        return $this->hasOne(ZoomOAuth::class);
    }

    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            ZoomOAuth::create([
                'user_id' => $user->id,
            ]);
        });
    }
}
