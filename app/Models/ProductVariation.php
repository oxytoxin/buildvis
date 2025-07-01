<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductVariation extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['product'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'minimum_stock_quantity' => 'integer',
        'minimum_order_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = ['product_slug'];


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

    public function workCategories(): BelongsToMany
    {
        return $this->belongsToMany(WorkCategory::class)
            ->withTimestamps();
    }

    public function productSlug(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->product->name . '-' . $this->name,
        );
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($variation) {
            $variation->product_name = $variation->product->name;
            $variation->save();
        });

        static::updated(function ($variation) {
            $variation->product_name = $variation->product->name;
            $variation->save();
        });
    }
}
