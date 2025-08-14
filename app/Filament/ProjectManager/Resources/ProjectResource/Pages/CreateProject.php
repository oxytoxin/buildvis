<?php

namespace App\Filament\ProjectManager\Resources\ProjectResource\Pages;

use App\Filament\ProjectManager\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
}
