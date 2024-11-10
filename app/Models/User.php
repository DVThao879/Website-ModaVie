<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ADMIN_ROLE = 2;
    const STAFF_ROLE = 1;
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'image',
        'email_verified_at',
        'email_verification_expires_at',
        'password',
        'role',
        'is_active'
      
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification_expires_at' => 'datetime', 
        'password' => 'hashed',
        'is_active' => 'boolean',
        
    ];
    public function isAdminOrStaff()
    {
        return $this->role == self::ADMIN_ROLE || $this->role == self::STAFF_ROLE;
    }
    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
