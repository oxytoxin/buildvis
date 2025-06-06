<?php

namespace App\Filament\Store\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use Auth;
use DB;
use Filament\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class CartIndex extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $view = 'filament.store.pages.cart-index';

    protected static ?string $navigationLabel = "Cart";

    protected ?string $heading = "Cart Details";

    protected static ?int $navigationSort = 2;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('checkout')
                ->requiresConfirmation()
                ->action(function () {
                    $order = Order::query()->where('customer_id', Auth::user()->customer?->id)->where('status', 'pending')->with('items')->first();
                    redirect()->route('stripe.checkout', ['order' => $order->id]);
                }),
        ];
    }

    public function table(Table $table)
    {
        return $table
            ->query(OrderItem::query()->whereRelation('order', 'customer_id', Auth::user()->customer?->id)->whereRelation('order', 'status', 'pending'))
            ->columns([
                TextColumn::make('product_variation.product.name')->searchable()->label('Product'),
                TextColumn::make('product_variation.name')->searchable()->label('Variation'),
                TextColumn::make('unit_price')->money('PHP')->sortable(),
                TextColumn::make('quantity')->size('xs')->sortable(),
                TextColumn::make('subtotal')->money('PHP')->sortable()->summarize(Sum::make('Grand Total')->money('PHP')->label('Grand Total')),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->rules('required', 'numeric', 'min:1'),
                    ]),
                DeleteAction::make(),
            ]);
    }
}
