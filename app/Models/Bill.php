<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'note',
        'vourcher_id',
        'order_code',
        'is_guest'
    ];
    
    protected $casts = [
       
        'is_guest' => 'boolean',
        
    ];  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }

}
