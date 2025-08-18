<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ProjectManagerRankings extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static string $view = 'filament.pages.project-manager-rankings';

    public function table(Table $table): Table
    {
        return $table->query(User::query())
            ->modifyQueryUsing(fn ($query) => $query->whereRelation('roles', 'name', 'project manager')->withAvg(['managed_projects as rating' => function ($query) {
                $query->whereNotNull('rating');
            }], 'rating')->orderBy('rating', 'desc')->whereHas('managed_projects', fn ($query) => $query->whereNotNull('rating'))
            )
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('rank')->getStateUsing(fn ($rowLoop) => $rowLoop->iteration),
                \Filament\Tables\Columns\TextColumn::make('name'),
                \Filament\Tables\Columns\TextColumn::make('rating'),
            ])
            ->emptyStateHeading('No project managers with ratings yet.');
    }
}
