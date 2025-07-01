<?php

namespace App\Filament\Store\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderTracking extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static string $view = 'filament.store.pages.order-tracking';

    protected static ?string $title = 'My Orders';

    protected static ?string $slug = 'my-orders';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = true;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->whereHas('customer', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->with(['customer.user', 'items.product_variation.product'])
            )
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
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'primary' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'secondary' => 'refunded',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('shipping_address')
                    ->label('Shipping Address')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Order Status'),
                SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->label('Payment Status'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Ordered From'),
                        DatePicker::make('created_until')
                            ->label('Ordered Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->label('Order Date Range'),
            ])
            ->actions([])
            ->bulkActions([
                BulkActionGroup::make([
                    // No bulk actions for customers
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    protected function getHeaderActions(): array
    {
        return [
            // No actions for customers
        ];
    }
}
