<?php

namespace App\Filament\Store\Resources\ProjectResource\Pages;

use App\Filament\Store\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProjects extends ManageRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function ($data) {
                $data['user_id'] = auth()->id();

                return $data;
            }),
        ];
    }
}
