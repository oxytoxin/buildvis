<?php

namespace App\Filament\Store\Resources\OrderResource\Pages;

use App\Filament\Store\Resources\OrderResource;
use Filament\Resources\Pages\ManageRecords;

class ManageOrders extends ManageRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
