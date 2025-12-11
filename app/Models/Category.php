<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = ['name', 'image', 'treatment_id', 'status'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function treatment()
    {
        return $this->belongsTo('App\Models\Treatments');
    }

    public function expertise()
    {
        return $this->hasOne('App\Models\Expertise');
    }

    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor');
    }
}
