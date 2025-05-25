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
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                        'slug' => $product->category->slug,
                    ],
                    'unit' => $product->unit,
                    'variations' => $product->variations->map(function ($variation) {
                        return [
                            'id' => $variation->id,
                            'name' => $variation->name,
                            'price' => $variation->price,
                            'sku' => $variation->sku,
                            'stock_quantity' => $variation->stock_quantity,
                            'is_active' => $variation->is_active,
                        ];
                    }),
                ];
            });

        return Inertia::render('Store/Index', [
            'products' => $products,
        ]);
    }
}
