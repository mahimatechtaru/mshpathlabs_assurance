<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatments extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = ['name', 'image', 'status'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category');
    }

    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor');
    }
}
