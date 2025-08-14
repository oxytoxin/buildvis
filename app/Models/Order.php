<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function scopeNotInCart(Builder $query): Builder
    {
        return $query->where('status', '!=', 'cart');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function booted(): void
    {
        static::creating(function ($order) {
            $order->name ??= 'Default';
            $order->status ??= 'cart';
        });
    }
}
