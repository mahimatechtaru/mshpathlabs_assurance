<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{
    use HasFactory;

    protected $table = 'pathology';

    protected $fillable = ['lab_id', 'report_days', 'test_name', 'charge', 'pathology_category_id', 'status', 'method', 'prescription_required'];

    public function pathology_category()
    {
        return $this->belongsTo('App\Models\PathologyCategory');
    }

    public function lab()
    {
        return $this->belongsTo('App\Models\Lab');
    }
}
