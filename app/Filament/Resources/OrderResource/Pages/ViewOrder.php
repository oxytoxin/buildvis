<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\MessageTypes;
use App\Enums\PaymentStatuses;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public $message;

    public $file;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Order Details')
                            ->schema([
                                Section::make('Order Information')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('total_amount')
                                                    ->label('Total Amount')
                                                    ->money('PHP'),
                                                TextEntry::make('payment_status')
                                                    ->badge(),
                                                TextEntry::make('payment_method')
                                                    ->label('Payment Method'),
                                            ]),
                                        TextEntry::make('placed_at')
                                            ->label('Order Date')
                                            ->dateTime('M d, Y H:i'),

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
                            ]),
                        Tabs\Tab::make('Chat and Payment')
                            ->schema(fn ($record) => [
                                ViewEntry::make('chat')->view('components.order-chat-messages', [
                                    'order' => $record,
                                ]),
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('confirm_payment')
                ->requiresConfirmation()
                ->action(function ($record) {
                    dd($record);
                })
                ->visible(fn ($record) => $record->payment_status === PaymentStatuses::PENDING),
        ];
    }

    public function sendMessage(): void
    {
        if ($this->file) {
            $path = $this->file->store('orders', 's3');
            $url = Storage::disk('s3')->url($path);
            $this->order->messages()->create([
                'type' => MessageTypes::IMAGE,
                'content' => $url,
                'user_id' => auth()->id(),
            ]);
        }
        if ($this->message) {
            $this->record->messages()->create([
                'content' => $this->message,
                'user_id' => auth()->id(),
            ]);
        }
        $this->reset(['message', 'file']);
    }
}
