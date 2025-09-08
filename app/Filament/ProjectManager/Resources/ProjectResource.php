<?php

namespace App\Filament\ProjectManager\Resources;

use App\Filament\ProjectManager\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('project_manager_id', auth()->user()->id);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\TextColumn::make('created_at')->date('M d, Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('tasks')->button()->outlined()->url(fn ($record) => route('filament.project-manager.resources.projects.tasks', ['record' => $record])),
                Tables\Actions\Action::make('documents')->button()->color('success')->outlined()->url(fn ($record) => route('filament.project-manager.resources.projects.documents', ['record' => $record])),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
            'tasks' => Pages\ProjectTasks::route('/{record}/tasks'),
            'documents' => Pages\ProjectDocuments::route('/{record}/documents'),
        ];
    }
}
