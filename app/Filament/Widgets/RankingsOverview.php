<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RankingsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $top_project_manager = User::whereRelation('roles', 'name', 'project manager')->whereRelation('managed_projects', 'rating', '!=', null)->withAvg(['managed_projects as rating' => function ($query) {
            $query->whereNotNull('rating');
        }], 'rating')->orderBy('rating')->first();

        return [
            Stat::make('Top Project Manager', $top_project_manager ? $top_project_manager->name.' - '.number_format($top_project_manager->rating, 2).' ⭐' : 'No ratings yet.')
//                ->description('Click to View Rankings')
                ->icon('heroicon-o-star')
                ->color('primary'),
        ];
    }
}
