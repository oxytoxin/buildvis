<?php

namespace App\Filament\Store\Resources\ProductResource\Pages;

use App\Filament\Store\Resources\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\Page;

class ProductView extends Page
{
    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.store.resources.product-resource.pages.product-view';

    public Product $product;
}
