<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalGallery extends Model
{
    use HasFactory;

    protected $table = 'hospital_gallery';

    protected $fillable = ['hospital_id', 'image'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }
}
