<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Order ID'),
                                TextEntry::make('name')
                                    ->label('Order Name'),
                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    }),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('total_amount')
                                    ->label('Total Amount')
                                    ->money('PHP'),
                                TextEntry::make('payment_status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'paid' => 'success',
                                        'failed' => 'danger',
                                        'refunded' => 'secondary',
                                    }),
                                TextEntry::make('payment_method')
                                    ->label('Payment Method'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Order Date')
                                    ->dateTime('M d, Y H:i'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime('M d, Y H:i'),
                            ]),
                    ]),

                Section::make('Customer Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('customer.user.name')
                                    ->label('Customer Name'),
                                TextEntry::make('customer.user.email')
                                    ->label('Customer Email'),
                            ]),
                        TextEntry::make('shipping_address')
                            ->label('Shipping Address')
                            ->markdown(),
                    ]),

                Section::make('Order Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        TextEntry::make('product_variation.product.name')
                                            ->label('Product'),
                                        TextEntry::make('quantity')
                                            ->label('Quantity'),
                                        TextEntry::make('unit_price')
                                            ->label('Unit Price')
                                            ->money('PHP'),
                                        TextEntry::make('subtotal')
                                            ->label('Subtotal')
                                            ->money('PHP'),
                                    ]),
                            ])
                            ->contained(false),
                    ]),

                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Order Notes')
                            ->markdown(),
                    ])
                    ->collapsible(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
