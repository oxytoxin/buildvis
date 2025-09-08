<?php

namespace App\Filament\ProjectManager\Resources\ProjectResource\Pages;

use App\Enums\ProjectTaskStatuses;
use App\Filament\Resources\ProjectResource;
use App\Models\Task;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Resources\Pages\TreePage as BasePage;

class ProjectTasks extends BasePage
{
    protected static string $resource = ProjectResource::class;

    public $project_id;

    public function mount($record): void
    {
        $this->project_id = $record;
    }

    protected function getTreeQuery(): Builder
    {
        return Task::query();
    }

    protected static int $maxDepth = 2;

    protected function getActions(): array
    {
        return [
            CreateAction::make()->label('Create Task')
                ->form([
                    Select::make('parent_id')->options(Task::query()->where('project_id', $this->project_id)->pluck('title', 'id'))->label('Parent Task'),
                    TextInput::make('title')->required(),
                    TextInput::make('description'),
                    DatePicker::make('start_date')->required()->default(now()),
                    DatePicker::make('end_date')->required()->default(now()->addDays(1)),
                ])
                ->action(function ($data) {
                    $data['project_id'] = $this->project_id;
                    Task::query()->create($data);
                }),
        ];
    }

    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        if ($record->parent_id == -1) {
            return null;
        }

        return match ($record->status) {
            ProjectTaskStatuses::PENDING => 'heroicon-o-exclamation-circle',
            ProjectTaskStatuses::COMPLETED => 'heroicon-o-check-circle',
            default => null,
        };
    }

    protected function getTreeActions(): array
    {
        return [
            EditAction::make()
                ->form([
                    TextInput::make('title')->required(),
                    TextInput::make('description'),
                    Select::make('status')->options(ProjectTaskStatuses::class)->label('Status')->required(),
                    DatePicker::make('start_date')->required(),
                    DatePicker::make('end_date')->required(),
                ]),
            DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }
}
