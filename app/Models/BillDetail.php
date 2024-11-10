<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'product_variant_id',
        'product_name',
        'quantity',
        'price',
        'size',
        'color',
    ];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

}
