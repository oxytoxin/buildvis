<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperShippingInformation
 */
class ShippingInformation extends Model
{

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
