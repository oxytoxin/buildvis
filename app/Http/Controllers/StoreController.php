<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variations'])
            ->get();

        return Inertia::render('Store/Index', [
            'products' => $products,
        ]);
    }

    public function product_view(Product $product)
    {
        return Inertia::render('ProductView', [
            'product' => $product->load(['variations.featured_image', 'variations.images']),
            'model' => $product->getFirstMedia('model')
        ]);
    }
}
