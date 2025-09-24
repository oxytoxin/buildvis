<?php

namespace App\Filament\Store\Resources\ProjectResource\Pages;

use App\Filament\Store\Resources\ProjectResource;
use App\Jobs\ChooseHouseModelJob;
use App\Models\BudgetEstimate;
use App\Models\HouseModel;
use Filament\Resources\Pages\Page;
use Storage;

class HouseGenerator extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.store.resources.project-resource.pages.house-generator';

    public BudgetEstimate $budget_estimate;

    public string $model_url = '';

    public ?HouseModel $model = null;

    public function mount($record): void
    {
        $this->budget_estimate = BudgetEstimate::find($record);
        if ($this->budget_estimate->house_model_id) {
            $this->model_url = Storage::disk('s3')->url($this->budget_estimate->house_model->model_url);
            $this->model = $this->budget_estimate->house_model;
        } else {
            if ($this->budget_estimate->house_model_status === 'none') {
                ChooseHouseModelJob::dispatch($this->budget_estimate);
                $this->budget_estimate->update(['house_model_status' => 'generating']);
            }
        }
    }
}
