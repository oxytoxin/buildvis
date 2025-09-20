<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product_variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public static function booted()
    {
        static::updated(function (OrderItem $orderItem) {
            $orderItem->order->update([
                'total_amount' => $orderItem->order->items()->sum('subtotal'),
            ]);
        });
        static::created(function (OrderItem $orderItem) {
            $orderItem->order->update([
                'total_amount' => $orderItem->order->items()->sum('subtotal'),
            ]);
        });
        static::deleted(function (OrderItem $orderItem) {
            $orderItem->order->update([
                'total_amount' => $orderItem->order->items()->sum('subtotal'),
            ]);
        });
    }
}
