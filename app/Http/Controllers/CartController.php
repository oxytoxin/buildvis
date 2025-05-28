<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'variation_id' => 'required|exists:product_variations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $variation = ProductVariation::with('product')->findOrFail($request->variation_id);

        // Check if variation is active
        if (!$variation->is_active) {
            throw ValidationException::withMessages([
                'variation_id' => 'This product variation is not available'
            ]);
        }

        // Check stock
        if ($variation->stock_quantity < $request->quantity) {
            throw ValidationException::withMessages([
                'variation_id' => 'Not enough stock available'
            ]);
        }

        // Get or create pending order for customer
        $order = Order::firstOrCreate(
            [
                'customer_id' => Auth::user()->customer->id,
                'status' => 'pending'
            ],
            [
                'name' => 'Default',
                'shipping_address' => Auth::user()->customer->default_shipping_information?->address,
                'billing_address' => Auth::user()->customer->default_shipping_information?->address,
            ]
        );

        // Check if item already exists in cart
        $existingItem = $order->items()
            ->where('product_variation_id', $variation->id)
            ->first();

        if ($existingItem) {
            // Check if new total quantity exceeds stock
            $newQuantity = $existingItem->quantity + $request->quantity;
            if ($variation->stock_quantity < $newQuantity) {
                throw ValidationException::withMessages([
                    'variation_id' => 'Adding this quantity would exceed available stock'
                ]);
            }
            // Update quantity if item exists
            $existingItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            // Create new order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_variation_id' => $variation->id,
                'quantity' => $request->quantity,
                'unit_price' => $variation->price,
            ]);
        }
    }
}
