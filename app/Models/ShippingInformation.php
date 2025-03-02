<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

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
}
