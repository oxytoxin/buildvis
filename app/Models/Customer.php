<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    public function default_shipping_information()
    {
        return $this->hasOne(ShippingInformation::class)->whereDefault(true);
    }

    public function shipping_information()
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
                'billing_address' => $customer->default_shipping_information?->address,
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
