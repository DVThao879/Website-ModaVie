<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'total',
        'payment_method',
        'status',
        'date',
        'note',
        'discount',
        'order_code'
    ];
 
   
}
