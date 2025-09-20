<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkCategory extends Model
{
    public function product_variations(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class)
            ->withTimestamps();
    }
}
