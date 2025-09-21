<?php

namespace App\Filament\Resources\HouseModelResource\Pages;

use App\Filament\Resources\HouseModelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHouseModel extends EditRecord
{
    protected static string $resource = HouseModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
