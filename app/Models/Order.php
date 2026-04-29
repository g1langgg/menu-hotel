<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'type',
        'number',
        'total_price',
        'status',
        'notes',
        'payment_method',
        'payment_status',
        'payment_receipt'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected $casts = [
        'total_price' => 'decimal:2'
    ];
}
