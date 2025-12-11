<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacySettle extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_settle';

    protected $fillable = ['purchase_medicine_id', 'pharmacy_id', 'admin_amount', 'pharmacy_amount', 'payment', 'pharmacy_status'];
}
