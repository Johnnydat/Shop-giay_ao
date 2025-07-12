<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'phone',
        'status',
        'avatar',
        'shipping_address',
        'gender',
        'role',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'password' => 'hashed',
    //     ];
    // }

    protected $casts = [
        'password' => 'hashed',
    ];
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relationship với bảng orders (đơn hàng)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
