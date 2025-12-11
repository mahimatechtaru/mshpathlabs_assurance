<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_address';

    protected $fillable = ['address', 'lat', 'lang', 'user_id', 'label'];

    public function UserAddress()
    {
        return $this->hasOne('App\Models\UserAddress');
    }
}
