<?php

namespace App\Filament\Store\Resources;

use App\Enums\OrderStatuses;
use App\Enums\PaymentStatuses;
use App\Filament\Store\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('customer_id', auth()->user()->customer->id)->whereNotNull('placed_at');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Order Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('PHP')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('payment_status')
                    ->badge(),
                TextColumn::make('payment_method')
                    ->label('Payment Method'),
                TextColumn::make('shipping_address')
                    ->label('Shipping Address')
                    ->limit(50),
                TextColumn::make('placed_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(OrderStatuses::class),
                SelectFilter::make('payment_status')
                    ->options(PaymentStatuses::class),
            ])
            ->actions([
                ViewAction::make()->modalContent(fn ($record) => view('filament.store.resources.order-resource.order-items', ['order' => $record])),
                Action::make('Contact Seller')
                    ->url(fn ($record) => route('filament.store.resources.orders.chat', ['record' => $record])),
            ])
            ->bulkActions([
            ])
            ->defaultSort('placed_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrders::route('/'),
            'chat' => Pages\OrderChat::route('/{record}/chat'),
        ];
    }
}
