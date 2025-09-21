<?php

namespace App\Filament\Resources\HouseModelResource\Pages;

use App\Filament\Resources\HouseModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHouseModel extends CreateRecord
{
    protected static string $resource = HouseModelResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
