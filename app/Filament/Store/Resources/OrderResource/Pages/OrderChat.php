<?php

namespace App\Filament\Store\Resources\OrderResource\Pages;

use App\Enums\MessageTypes;
use App\Filament\Store\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class OrderChat extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.store.resources.order-resource.pages.order-chat';

    public Order $order;

    public $data;

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('file')->acceptedFileTypes(['image/jpeg', 'image/png'])->hiddenLabel()->previewable(false)->storeFiles(false)->maxFiles(1),
            Textarea::make('message')->hiddenLabel()->rows(3)->maxLength(255)->columnSpan(2),
        ])->columns(3)->statePath('data');
    }

    public function mount(Order $record): void
    {
        $this->form->fill();
        $this->order = $record;
    }

    public function sendMessage(): void
    {
        $data = $this->form->getState();
        $file = $data['file'] ?? null;
        $message = $data['message'] ?? null;
        if ($file) {
            $path = $file->store('orders', 's3');
            $url = Storage::disk('s3')->url($path);
            $this->order->messages()->create([
                'type' => MessageTypes::IMAGE,
                'content' => $url,
                'user_id' => auth()->id(),
            ]);
        }
        if ($message) {
            $this->order->messages()->create([
                'content' => $message,
                'user_id' => auth()->id(),
            ]);
        }

        $this->form->fill();
    }
}
