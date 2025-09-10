<?php

namespace App\Filament\Store\Resources\ProjectResource\Pages;

use App\Filament\Store\Resources\ProjectResource;
use App\Models\BudgetEstimate;
use Filament\Resources\Pages\Page;

class HouseGenerator extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.store.resources.project-resource.pages.house-generator';

    public BudgetEstimate $budget_estimate;

    public string $model = '';

    public function mount($record): void
    {
        $this->budget_estimate = BudgetEstimate::find($record);
        if ($this->budget_estimate->budget > 500_000) {
            $this->model = asset('models/house-2.glb');
        } elseif ($this->budget_estimate->budget > 1_000_000) {
            $this->model = asset('models/house-5.glb');
        } elseif ($this->budget_estimate->budget > 1_500_000) {
            $this->model = asset('models/house-3.glb');
        } elseif ($this->budget_estimate->budget > 2_000_000) {
            $this->model = asset('models/house-6.glb');
        } elseif ($this->budget_estimate->budget > 3_000_000) {
            $this->model = asset('models/house-4.glb');
        } elseif ($this->budget_estimate->budget > 4_000_000) {
            $this->model = asset('models/house-7.glb');
        } else {
            $this->model = asset('models/house-1.glb');
        }
    }
}
