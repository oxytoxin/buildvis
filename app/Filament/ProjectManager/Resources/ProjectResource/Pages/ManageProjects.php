<?php

namespace App\Filament\ProjectManager\Resources\ProjectResource\Pages;

use App\Filament\ProjectManager\Resources\ProjectResource;
use Filament\Resources\Pages\ManageRecords;

class ManageProjects extends ManageRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
