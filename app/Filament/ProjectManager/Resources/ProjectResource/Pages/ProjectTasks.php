<?php

namespace App\Filament\ProjectManager\Resources\ProjectResource\Pages;

use App\Enums\ProjectTaskStatuses;
use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Task;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Resources\Pages\TreePage as BasePage;

class ProjectTasks extends BasePage
{
    protected static string $resource = ProjectResource::class;

    public int $project_id;

    protected static ?string $breadcrumb = 'Tasks';

    public function getHeading(): string|Htmlable
    {
        $project = Project::find($this->project_id);

        $completed_tasks = $project->completed_tasks;
        $tasks = $project->tasks;
        $progress = $tasks->count() > 0 ? $completed_tasks->sum('weight') / $tasks->sum('weight') * 100 : 0;

        return view('extras.project-tasks.project-progress-header', [
            'project' => $project,
            'completed_tasks_count' => $completed_tasks->count(),
            'tasks_count' => $tasks->count(),
            'progress' => $progress,
        ]);
    }

    public function mount($record): void
    {
        $this->project_id = $record;
    }

    protected function getWithRelationQuery(): Builder
    {
        $query = $this->getTreeQuery();
        if (method_exists($this->getModel(), 'children') && $this->getModel()::has('children')) {
            if (method_exists($this->getModel(), 'scopeOrdered')) {
                return $query->with('children', fn ($query) => $query->ordered());
            }

            return $query->with('children');
        }

        return $query;
    }

    public function getModel(): string
    {
        return Task::class;
    }

    protected function getTreeQuery(): Builder
    {
        return Task::query()->where('project_id', $this->project_id);
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

    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (! $record) {
            return '';
        }

        if ($record->parent_id == -1) {
            return $record->title;
        }

        return "{$record->title} \t <span class='border-2 rounded px-2 py-1 ml-6'>{$record->status->getLabel()}</span>";
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
