<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            if (!Auth::user()->customer) {
                return response()->json([
                    'message' => 'Customer account not found'
                ], 403);
            }

            $request->validate([
                'variation_id' => 'required|exists:product_variations,id',
                'quantity' => 'required|integer|min:1',
            ]);

            DB::beginTransaction();

            $variation = ProductVariation::with('product')->findOrFail($request->variation_id);

            // Check if variation is active
            if (!$variation->is_active) {
                return response()->json([
                    'message' => 'This product variation is not available'
                ], 422);
            }

            // Check stock
            if ($variation->stock_quantity < $request->quantity) {
                return response()->json([
                    'message' => 'Not enough stock available'
                ], 422);
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
                    return response()->json([
                        'message' => 'Adding this quantity would exceed available stock'
                    ], 422);
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

            DB::commit();

            return response()->json([
                'message' => 'Item added to cart successfully',
                'cart_count' => $order->items()->sum('quantity')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Add to cart failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'variation_id' => $request->variation_id,
                'quantity' => $request->quantity
            ]);
            return response()->json([
                'message' => 'Failed to add item to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
