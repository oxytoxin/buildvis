<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    public function default_shipping_information(): HasOne
    {
        return $this->hasOne(ShippingInformation::class)->whereDefault(true);
    }

    public function shipping_information(): HasMany
    {
        return $this->hasMany(ShippingInformation::class);
    }

    protected static function booted(): void
    {

        static::created(function (Customer $customer) {
            Order::create([
                'name' => 'Default',
                'customer_id' => $customer->id,
                'shipping_address' => $customer->default_shipping_information?->address,
            ]);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
