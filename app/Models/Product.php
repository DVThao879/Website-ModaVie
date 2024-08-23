<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'img_thumb',
        'price',
        'price_sale',
        'description',
        'category_id',
        'status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function galleries() {
        return $this->hasMany(ProductGallery::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}