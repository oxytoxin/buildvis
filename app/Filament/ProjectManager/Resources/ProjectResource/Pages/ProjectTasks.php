<?php

namespace App\Filament\ProjectManager\Resources\ProjectResource\Pages;

use App\Enums\ProjectTaskStatuses;
use App\Filament\ProjectManager\Resources\ProjectResource;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectTasks extends ManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'tasks';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Tasks';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('status')->options(ProjectTaskStatuses::class)->default(ProjectTaskStatuses::PENDING)->required(),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
                DatePicker::make('start_date')->required()->default(today()),
                DatePicker::make('end_date')->required()->default(today()->addDays(7)),
            ]);
    }

    public function table(Table $table): Table
    {
        $project = $this->getRecord();

        return $table
            ->recordTitleAttribute('name')
            ->modifyQueryUsing(fn ($query) => $query->orderBy('sort'))
            ->header(function () use ($project) {
                $completed_tasks_count = $project->completed_tasks()->count();
                $total_tasks_count = $project->tasks()->count();

                return view('extras.project-tasks.project-progress-header', [
                    'completed_tasks_count' => $completed_tasks_count,
                    'tasks_count' => $total_tasks_count,
                ]);
            })
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->reorderable('sort')
            ->actions([
                Tables\Actions\Action::make('complete')
                    ->visible(fn ($record) => $record->status === ProjectTaskStatuses::PENDING)
                    ->action(fn ($record) => $record->update(['status' => ProjectTaskStatuses::COMPLETED]))
                    ->color('success')
                    ->button()
                    ->icon('heroicon-o-check'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
