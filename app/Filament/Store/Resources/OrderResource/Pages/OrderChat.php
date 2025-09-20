<?php

namespace App\Filament\Store\Resources\OrderResource\Pages;

use App\Enums\MessageTypes;
use App\Filament\Store\Resources\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class OrderChat extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.store.resources.order-resource.pages.order-chat';

    public Order $order;

    public $message;

    public $file;

    public function mount(Order $record): void
    {
        $this->order = $record;
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
            $this->order->messages()->create([
                'content' => $this->message,
                'user_id' => auth()->id(),
            ]);
        }
        $this->reset(['message', 'file']);
    }
}
