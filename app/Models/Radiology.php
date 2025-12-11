<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radiology extends Model
{
    use HasFactory;

    protected $table = 'radiology';

    protected $fillable = ['status', 'report_days', 'lab_id', 'charge', 'radiology_category_id', 'screening_for'];

    public function radiology_category()
    {
        return $this->belongsTo('App\Models\RadiologyCategory');
    }

    public function lab()
    {
        return $this->belongsTo('App\Models\Lab');
    }
}
