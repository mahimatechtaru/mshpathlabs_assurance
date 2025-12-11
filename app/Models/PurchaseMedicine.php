<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseMedicine extends Model
{
    use HasFactory;

    protected $table = 'purchase_medicine';

    protected $fillable = ['medicine_id', 'user_id', 'amount', 'payment_type', 'payment_token', 'payment_status', 'admin_commission', 'pharmacy_commission', 'pharmacy_id', 'pdf', 'shipping_at', 'address_id', 'delivery_charge'];

    protected $appends = ['medicine_name'];

    public function getMedicineNameAttribute()
    {
        return MedicineChild::where('purchase_medicine_id', $this->attributes['id'])->get();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\UserAddress');
    }
}
