<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\SystemConfig;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Storage;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('gcash')
                ->label('Manage GCash QR')
                ->form([
                    FileUpload::make('qr_code')->storeFiles(false),
                ])
                ->action(function ($data) {
                    Storage::disk('s3')->delete('configs/gcash_qr.jpg');
                    $path = $data['qr_code']->storeAs('configs', 'gcash_qr.jpg', 's3');
                    $url = Storage::disk('s3')->url($path);
                    SystemConfig::setGcashQrUrl($url);
                    Notification::make()->title('GCash QR Updated')->success()->send();
                }),
        ];
    }
}
