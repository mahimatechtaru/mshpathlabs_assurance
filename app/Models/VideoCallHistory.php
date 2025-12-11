<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCallHistory extends Model
{
    use HasFactory;

    protected $table = 'videocall_history';

    protected $fillable = ['user_id', 'doctor_id', 'date', 'start_time', 'duration'];

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
