<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offer';

    protected $fillable = ['name', 'offer_code', 'image', 'max_use', 'use_count', 'min_discount', 'start_end_date', 'user_id', 'doctor_id', 'desc', 'discount', 'discount_type', 'is_flat', 'flatDiscount', 'status'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }
}
