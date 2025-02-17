<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProvince
 */
class Province extends Model
{

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }
}
