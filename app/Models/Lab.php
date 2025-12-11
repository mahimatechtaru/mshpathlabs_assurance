<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lab extends Model
{
    use HasFactory;

    protected $table = 'lab';

    protected $fillable = ['name', 'user_id', 'address', 'lat', 'lng', 'status', 'image', 'start_time', 'end_time', 'commission'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function workHours()
    {
        return $this->hasMany('App\Models\LabWorkHours');
    }

    public function scopeGetByDistance($query, $lat, $lng, $radius)
    {
        if ($lat !== null && $lng !== null) {
            $results = DB::select(
                'SELECT id, (3959 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance
                FROM lab
                HAVING distance < ?
                ORDER BY distance',
                [$lat, $lng, $lat, $radius]
            );

            $ids = array_map(fn ($r) => $r->id, $results);

            return $query->whereIn('id', $ids);
        }

        return $query->whereIn('id', []);
    }
}
