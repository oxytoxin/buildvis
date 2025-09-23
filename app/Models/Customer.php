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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
