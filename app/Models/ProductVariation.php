<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductVariation extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'minimum_stock_quantity' => 'integer',
        'minimum_order_quantity' => 'integer',
        'is_active' => 'boolean',
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    public function featured_image()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'images')
            ->oldestOfMany();
    }

    public function images()
    {
        return $this->media()
            ->where('collection_name', 'images');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeCountedInStats($query)
    {
        return $query->where('counted_in_stats', true);
    }
}
