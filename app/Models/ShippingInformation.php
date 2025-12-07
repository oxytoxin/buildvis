<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperShippingInformation
 */
class ShippingInformation extends Model
{
    public function address(): Attribute
    {
        return new Attribute(get: function () {
            return str(implode(',', [
                $this->region->name,
                $this->province->name,
                $this->city_municipality->name,
                $this->barangay?->name,
                $this->address_line_1,
                $this->address_line_2,
            ]))->trim(',')->toString();
        });
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function city_municipality()
    {
        return $this->belongsTo(CityMunicipality::class, 'city_municipality_code', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    protected static function booted()
    {
        static::creating(function ($shippingInformation) {
            if ($shippingInformation->customer->shipping_information()->count() === 0) {
                $shippingInformation->default = true;
            }
        });
    }
}
