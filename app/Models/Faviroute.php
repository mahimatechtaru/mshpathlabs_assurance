<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faviroute extends Model
{
    use HasFactory;

    protected $table = 'faviroute';

    protected $fillable = ['user_id', 'doctor_id'];
}
