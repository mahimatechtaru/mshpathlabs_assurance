<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospital';

    protected $fillable = ['name', 'phone', 'address', 'lat', 'lng', 'facility', 'status'];

    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor');
    }

    public function scopeGetByDistance($query, $lat, $lng, $radius)
    {
        if ($lat !== null && $lng !== null) {
            $results = DB::select(
                'SELECT id, (3959 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance
                FROM hospital
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
