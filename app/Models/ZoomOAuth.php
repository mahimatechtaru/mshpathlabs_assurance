<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomOAuth extends Model
{
    use HasFactory;

    protected $table = 'zoom_oauth';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //  Set expires_at attribute as Timestamp from seconds
    //  Usage:
    //  $user->zoomOAuth->expires_at = 3600;
    //  $user->zoomOAuth->save();
    public function setExpiresAtAttribute($value)
    {
        // Setting buffer of 2 minutes to avoid any issues
        $this->attributes['expires_at'] = now()->addSeconds($value - 120);
    }

    public function getIsAccessTokenValidAttribute()
    {
        if (isset($this->expires_at)) {
            return $this->expires_at->isFuture();
        }

        return 0;
    }
}
