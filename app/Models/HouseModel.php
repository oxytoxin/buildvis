<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Storage;

class HouseModel extends Model
{
    public function modelPublicUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk('s3')->url(self::$model_url ?? '')
        );
    }
}
