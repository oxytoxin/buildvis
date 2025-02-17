<?php

namespace App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages;

use App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCityMunicipalities extends ManageRecords
{
    protected static string $resource = CityMunicipalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
