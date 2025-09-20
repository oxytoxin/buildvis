<?php

namespace App\Models;

use App\Enums\ProductCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'category_id' => ProductCategories::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('model')
            ->onlyKeepLatest(1);
    }

    public function featured_image()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'images');
    }

    public function images()
    {
        return $this->media()
            ->where('collection_name', 'images');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public static function boot()
    {
        parent::boot();

        static::updated(function ($product) {
            $product->variations()->update([
                'product_name' => $product->name,
            ]);
        });
    }
}
