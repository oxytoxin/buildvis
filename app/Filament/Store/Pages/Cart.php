<?php

namespace App\Filament\Store\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariation;
use Auth;
use Filament\Actions\Action;
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
                ->action(function () {
                    $order = Order::query()->where('customer_id', Auth::user()->customer?->id)->where('status',
                        'cart')->with('items')->first();
                    redirect()->route('stripe.checkout', ['order' => $order->id]);
                }),
        ];
    }

    public function table(Table $table)
    {
        return $table
            ->query(
                OrderItem::query()
                    ->whereRelation('order', 'customer_id', Auth::user()->customer?->id)
                    ->whereRelation('order', 'status', 'cart')
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
