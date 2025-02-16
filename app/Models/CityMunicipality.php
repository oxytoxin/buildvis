<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityMunicipality extends Model
{
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
}
