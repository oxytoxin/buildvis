<?php

namespace App\Filament\Store\Resources;

use App\Filament\Store\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentRatingStar\Forms\Components\RatingStar;
use Illuminate\Database\Eloquent\Builder;

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

    public static function getEloquentQuery(): Builder
    {
        return Project::query()->with('project_manager')->whereBelongsTo(auth()->user(), 'customer');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('project_manager.name')->default('Unassigned'),
                Tables\Columns\TextColumn::make('rating')->default('Unrated')->suffix(' ⭐'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Action::make('rate')
                    ->icon('heroicon-o-star')
                    ->form(fn (Project $record) => [
                        Forms\Components\Placeholder::make('project_manager')->content($record->project_manager->name ?? 'Unassigned'),
                        RatingStar::make('rating'),
                    ])
                    ->action(function (Project $record, array $data): void {
                        $record->rating = $data['rating'];
                        $record->save();
                        Notification::make()
                            ->title('Project manager rated')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Project $record) => $record->project_manager_id),
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
            'house-generator' => Pages\HouseGenerator::route('/house-generator/{record}'),
            'floor-plan' => Pages\Floorplan::route('/floor-plan/{record}'),
        ];
    }
}
