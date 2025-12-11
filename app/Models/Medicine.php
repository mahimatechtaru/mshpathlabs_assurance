<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $table = 'medicine';

    protected $fillable = ['name', 'image', 'pharmacy_id', 'medicine_category_id', 'status', 'incoming_stock', 'total_stock', 'use_stock', 'description', 'works', 'price_pr_strip', 'number_of_medicine', 'prescription_required', 'meta_info'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function pharmacy()
    {
        return $this->belongsTo('App\Models\Pharmacy');
    }
}
