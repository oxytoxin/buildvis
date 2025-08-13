<?php

namespace App\Filament\Store\Resources;

use App\Filament\Store\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentRatingStar\Forms\Components\RatingStar;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('project_manager.name')->default('Unassigned'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ActionGroup::make([
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
                        ->visible(fn (Project $record) => $record->project_manager_id),
                    Action::make('rate')
                        ->icon('heroicon-o-star')
                        ->form(fn (Project $record) => [
                            Forms\Components\Placeholder::make('project_manager')->content($record->project_manager->name ?? 'Unassigned'),
                            RatingStar::make('rating'),
                        ])
                        ->action(function (Project $record, array $data): void {
                            $project_manager = $record->project_manager;
                            $project_manager->ratings()->updateOrCreate([
                                'project_id' => $record->id,
                                'customer_id' => $record->user->customer->id,
                            ], [
                                'role' => 'project manager',
                                'value' => $data['rating'],
                            ]);
                            Notification::make()
                                ->title('Project manager rated')
                                ->success()
                                ->send();
                        })
                        ->visible(fn (Project $record) => $record->project_manager_id),
                ]),
            ])
            ->recordUrl(fn (Project $record): string => Pages\ShowProject::getUrl(['project' => $record]))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
            'show' => Pages\ShowProject::route('/{project}'),
        ];
    }
}
