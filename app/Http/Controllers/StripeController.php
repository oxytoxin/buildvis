<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatuses;
use App\Models\Order;
use App\Models\OrderItem;
use DB;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout(Request $request, Order $order)
    {
        if ($order->items()->count() < 1) {
            Notification::make()->title('Your order is empty.')->warning()->send();

            return redirect(route('filament.store.pages.cart'));
        }
        Stripe::setApiKey(config('stripe.sk'));
        try {
            $session = Session::create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'php',
                            'product_data' => [
                                'name' => 'BuildVis Products',
                            ],
                            'unit_amount' => $order->total_amount * 100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.success', ['order' => $request->order]),
                'cancel_url' => route('stripe.cancel', ['order' => $request->order]),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            Notification::make()->title('Something went wrong with STRIPE.')->danger()->send();

            return redirect(route('filament.store.pages.cart'));
        }
    }

    public function success(Request $request, Order $order)
    {
        DB::beginTransaction();

        $order->update([
            'status' => OrderStatuses::PENDING,
        ]);
        $order->items()->with('product_variation')->each(function (OrderItem $orderItem) {
            $orderItem->product_variation->update([
                'stock_quantity' => $orderItem->product_variation->stock_quantity - $orderItem->quantity,
            ]);
        });
        $customer = $order->customer;
        Order::create([
            'name' => 'Default',
            'customer_id' => $customer->id,
            'shipping_address' => $customer->default_shipping_information?->address,
        ]);
        DB::commit();

        return view('stripe-success', [
            'order_id' => $request->order_id,
        ]);
    }

    public function cancel(Request $request)
    {
        return view('stripe-cancel', [
            'order_id' => $request->order_id,
        ]);
    }
}
