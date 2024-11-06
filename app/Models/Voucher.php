<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'start_date',
        'end_date',
        'quantity',
        'min_money',
        'max_money',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}