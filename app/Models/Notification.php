<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = ['user_id', 'doctor_id', 'title', 'user_type', 'message'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }
}
