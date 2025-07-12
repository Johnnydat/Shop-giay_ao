<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = [
        'pending'    => ['text' => 'Chờ xử lý',     'class' => 'bg-secondary text-white'],
        'processing' => ['text' => 'Đang xử lý',     'class' => 'bg-warning text-dark'],
        'shipped'    => ['text' => 'Đang giao hàng', 'class' => 'bg-info text-dark'],
        'delivered'  => ['text' => 'Đã giao hàng',   'class' => 'bg-success'],
        'cancelled'  => ['text' => 'Đã hủy',         'class' => 'bg-danger'],
    ];


    protected $fillable = [
        'user_id',
        'order_code',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes'
    ];

    public function getStatusTextAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
    public function scopeForUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Other relationships, e.g., with the order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
