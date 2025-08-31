<?php

namespace App\Filament\Store\Resources\ProjectResource\Pages;

use App\Filament\Store\Resources\ProjectResource;
use App\Models\BudgetEstimate;
use Filament\Resources\Pages\Page;

class Floorplan extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.store.resources.project-resource.pages.floorplan';

    public BudgetEstimate $budget_estimate;

    public function mount($record): void
    {
        $this->budget_estimate = BudgetEstimate::find($record);
    }
}
