<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatuses;
use App\Enums\PaymentStatuses;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

    public static function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->notInCart())
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Order Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer.user.email')
                    ->label('Customer Email')
                    ->searchable(),
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
                    ->label('Order Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(OrderStatuses::class)
                    ->label('Order Status'),
                SelectFilter::make('payment_status')
                    ->options(PaymentStatuses::class)
                    ->label('Payment Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('update_status')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->form([
                        Select::make('status')
                            ->label('New Status')
                            ->options(OrderStatuses::class)
                            ->required(),
                        Select::make('payment_status')
                            ->label('Payment Status')
                            ->options(PaymentStatuses::class)
                            ->required(),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $record->update($data);
                    })
                    ->color('primary'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('update_status_bulk')
                        ->label('Update Status')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            Select::make('status')
                                ->label('New Status')
                                ->options(OrderStatuses::class)
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function ($record) use ($data) {
                                $record->update($data);
                            });
                        })
                        ->color('primary'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [
            // We'll add this later if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', OrderStatuses::PENDING)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', OrderStatuses::PENDING)->count() > 0 ? 'warning' : null;
    }
}
