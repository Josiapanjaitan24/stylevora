<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_number', 'status', 'payment_method', 'total_price', 'shipping_address', 'phone', 'notes', 'confirmed_at', 'shipped_at', 'delivered_at'];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
