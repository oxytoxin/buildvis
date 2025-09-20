<?php

namespace App\Filament\Store\Resources\ProductResource\Pages;

use App\Filament\Store\Resources\ProductResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariation;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductView extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.store.resources.product-resource.pages.product-view';

    public Model|Product $product;

    public array $cartData = [];

    public ?Media $model;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->product = $this->record;
        $this->cartData = [];
        if (Auth::check() && Auth::user()->customer) {
            $pendingOrder = Order::where('customer_id', Auth::user()->customer->id)
                ->where('status', 'pending')
                ->with('items.product_variation')
                ->first();

            if ($pendingOrder) {
                foreach ($pendingOrder->items as $item) {
                    $this->cartData[$item->product_variation_id] = $item->quantity;
                }
            }
        }
        $this->product = $this->product->load(['variations.featured_image', 'variations.images', 'featured_image']);
        $this->model = $this->product->getFirstMedia('model');
    }

    public function addToCart($selected_variation, $quantity)
    {

        $variation = ProductVariation::with('product')->find($selected_variation);
        if (! $variation) {
            Notification::make()->title('Product variation not found')->danger()->send();

            return ['status' => 422];
        }
        // Check if variation is active
        if (! $variation->is_active) {
            Notification::make()->title('This product variation is not available')->danger()->send();

            return ['status' => 422];
        }

        // Check stock
        if ($variation->stock_quantity < $quantity) {
            Notification::make()->title('Not enough stock available')->danger()->send();

            return ['status' => 422];

        }

        // Get or create pending order for customer
        $order = Order::firstOrCreate(
            [
                'customer_id' => Auth::user()->customer->id,
                'status' => 'cart',
            ],
            [
                'name' => 'Default',
                'shipping_address' => Auth::user()->customer->default_shipping_information?->address,
            ]
        );

        // Check if an item already exists in the cart
        $existingItem = $order->items()
            ->where('product_variation_id', $variation->id)
            ->first();

        if ($existingItem) {
            // Check if the new total quantity exceeds stock
            $newQuantity = $existingItem->quantity + $quantity;
            if ($variation->stock_quantity < $newQuantity) {
                Notification::make()->title('Adding this quantity would exceed available stock')->danger()->send();

                return ['status' => 422];

            }
            // Update quantity if the item exists
            $existingItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            // Create a new order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_variation_id' => $variation->id,
                'quantity' => $quantity,
                'unit_price' => $variation->price,
            ]);
        }

        Notification::make()->title('Item added to cart!')->success()->send();

        return ['status' => 200];

    }
}
