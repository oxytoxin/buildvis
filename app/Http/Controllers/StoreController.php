<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variations'])
            ->get();

        // Get cart data for current user
        $cartData = [];
        if (Auth::check() && Auth::user()->customer) {
            $pendingOrder = Order::where('customer_id', Auth::user()->customer->id)
                ->where('status', 'pending')
                ->with('items.product_variation')
                ->first();

            if ($pendingOrder) {
                foreach ($pendingOrder->items as $item) {
                    $cartData[$item->product_variation_id] = $item->quantity;
                }
            }
        }

        return Inertia::render('Store/Index', [
            'products' => $products,
            'cartData' => $cartData,
        ]);
    }

    public function product_view(Product $product)
    {
        // Get cart data for current user
        $cartData = [];
        if (Auth::check() && Auth::user()->customer) {
            $pendingOrder = Order::where('customer_id', Auth::user()->customer->id)
                ->where('status', 'pending')
                ->with('items.product_variation')
                ->first();

            if ($pendingOrder) {
                foreach ($pendingOrder->items as $item) {
                    $cartData[$item->product_variation_id] = $item->quantity;
                }
            }
        }

        return Inertia::render('ProductView', [
            'product' => $product->load(['variations.featured_image', 'variations.images', 'featured_image']),
            'model' => $product->getFirstMedia('model'),
            'cartData' => $cartData,
        ]);
    }
}
