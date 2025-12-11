<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    use HasFactory;

    protected $table = 'expertise';

    protected $fillable = ['name', 'status', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor');
    }
}
