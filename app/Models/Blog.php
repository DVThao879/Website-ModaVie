<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'img_avt',
        'content',
        'is_active',
        'view',
        'user_id',
    ];

    protected $casts =[
        'is_active'=> 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
