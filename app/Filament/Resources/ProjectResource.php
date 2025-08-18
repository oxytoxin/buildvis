<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\TextColumn::make('project_manager.name')->default('Unassigned'),
                Tables\Columns\TextColumn::make('rating')->default('Unrated')->suffix(' ⭐'),
                Tables\Columns\TextColumn::make('created_at')->date('M d, Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('assign')
                    ->label(fn (Project $record) => $record->project_manager_id ? 'Reassign' : 'Assign')
                    ->icon('heroicon-o-user-group')
                    ->form(fn (Project $record) => [
                        Select::make('project_manager_id')
                            ->label('Project manager')
                            ->options(
                                User::whereRelation('roles', 'name', 'project manager')
                                    ->pluck('name', 'id')
                            ),
                    ])
                    ->visible(fn (Project $record) => $record->rating === null)
                    ->fillForm(fn (Project $record, array $data) => ['project_manager_id' => $record->project_manager_id])
                    ->action(function (Project $record, array $data): void {
                        $record->project_manager_id = $data['project_manager_id'];
                        $record->save();
                        Notification::make()
                            ->title('Project manager assigned')
                            ->success()
                            ->send();
                    }),
                Action::make('unassign')
                    ->icon('heroicon-o-user-group')
                    ->action(function (Project $record): void {
                        $record->project_manager_id = null;
                        $record->save();
                        Notification::make()
                            ->title('Project manager unassigned')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Project $record) => $record->project_manager_id && $record->rating === null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
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
        ];
    }
}
