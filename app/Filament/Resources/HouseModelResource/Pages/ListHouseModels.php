<?php

namespace App\Filament\Resources\HouseModelResource\Pages;

use App\Filament\Resources\HouseModelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHouseModels extends ListRecords
{
    protected static string $resource = HouseModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
