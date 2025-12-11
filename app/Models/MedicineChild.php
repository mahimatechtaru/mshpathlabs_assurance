<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineChild extends Model
{
    use HasFactory;

    protected $table = 'medicine_child';

    protected $fillable = ['purchase_medicine_id', 'medicine_id', 'price', 'qty'];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        if ($this->attributes['medicine_id'] != null) {
            return Medicine::where('id', $this->attributes['medicine_id'])->first()->name;
        } else {
            return null;
        }
    }
}
