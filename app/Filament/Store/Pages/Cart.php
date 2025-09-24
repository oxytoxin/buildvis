<?php

namespace App\Filament\Store\Pages;

use App\Enums\OrderStatuses;
use App\Enums\PaymentMethods;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use App\Models\ShippingInformation;
use Auth;
use DB;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Cart extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $view = 'filament.store.pages.cart';

    protected static ?int $navigationSort = 2;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('checkout')
                ->requiresConfirmation()
                ->form([
                    Select::make('payment_method')
                        ->options(PaymentMethods::class)
                        ->default(PaymentMethods::CASH_ON_DELIVERY),
                    Select::make('shipping_information_id')
                        ->label('Shipping Address')
                        ->options(fn () => Auth::user()->customer->shipping_information->pluck('address', 'id'))
                        ->required()
                        ->default(Auth::user()->customer->default_shipping_information->id),
                ])
                ->action(function ($data) {
                    DB::beginTransaction();

                    $order = Order::query()->where('customer_id', Auth::user()->customer?->id)->where('status', OrderStatuses::CART)->firstOrFail();
                    $order->status = OrderStatuses::PENDING;
                    $order->payment_method = $data['payment_method'];
                    $order->shipping_address = ShippingInformation::query()->findOrFail($data['shipping_information_id'])->address;
                    $order->placed_at = now();
                    foreach ($order->items as $item) {
                        $new_quantity = $item->product_variation->stock_quantity - $item->quantity;
                        if ($new_quantity < 0) {
                            DB::rollBack();
                            Notification::make()->title('Not enough stock available for '.$item->product_variation->slug)->warning()->send();

                            return;
                        }
                        $item->product_variation->update([
                            'stock_quantity' => $new_quantity,
                        ]);
                    }
                    $order->save();

                    DB::commit();
                    Notification::make()->title('Order placed successfully!')->success()->send();
                    $this->redirect(route('filament.store.resources.orders.chat', ['record' => $order]));
                }),
        ];
    }

    public function table(Table $table)
    {
        return $table
            ->query(
                OrderItem::query()
                    ->whereRelation('order', 'customer_id', Auth::user()->customer?->id)
                    ->whereRelation('order', 'status', OrderStatuses::CART)
            )
            ->columns([
                TextColumn::make('product_variation.product.name')->searchable()->label('Product'),
                TextColumn::make('product_variation.name')->searchable()->label('Variation'),
                TextColumn::make('unit_price')->money('PHP')->sortable(),
                TextColumn::make('quantity')->size('xs')->sortable(),
                TextColumn::make('subtotal')->money('PHP')->sortable()->summarize(Sum::make('Grand Total')->money('PHP')->label('Grand Total')),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('add')->icon('heroicon-o-plus')->label(false)
                    ->button()
                    ->outlined()
                    ->action(function ($record) {
                        $record->quantity = $record->quantity + 1;
                        $variation = ProductVariation::with('product')->findOrFail($record->product_variation_id);
                        if ($variation->stock_quantity < $record->quantity) {
                            Notification::make()->title('Not enough stock available');

                            return;
                        }
                        $record->save();
                    }),
                \Filament\Tables\Actions\Action::make('subtract')->icon('heroicon-o-minus')->label(false)
                    ->button()
                    ->outlined()
                    ->action(function ($record) {
                        if ($record->quantity > 0) {
                            $record->quantity = $record->quantity - 1;
                            $record->save();
                        }
                    }),
                EditAction::make()
                    ->form([
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $record->quantity = $data['quantity'];
                        $variation = ProductVariation::with('product')->findOrFail($record->product_variation_id);
                        if ($variation->stock_quantity < $record->quantity) {
                            Notification::make()->title('Not enough stock available');

                            return;
                        }
                        $record->save();
                    }),
                DeleteAction::make(),
            ]);
    }
}
