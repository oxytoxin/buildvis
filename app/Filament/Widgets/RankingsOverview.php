<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RankingsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $top_employee = User::whereRelation('roles', 'name', 'employee')->whereHas('ratings', function ($query) {
            $query->where('role', 'employee');
        })->withAvg(['ratings as rating' => function ($query) {
            $query->where('role', 'employee');
        }], 'value')->orderBy('rating')->first();
        $top_project_manager = User::whereRelation('roles', 'name', 'project manager')->whereHas('ratings', function ($query) {
            $query->where('role', 'project manager');
        })->withAvg(['ratings as rating' => function ($query) {
            $query->where('role', 'project manager');
        }], 'value')->orderBy('rating')->first();

        return [
            Stat::make('Top Employee', $top_employee ? $top_employee->name.' - '.number_format($top_employee->rating, 2) : 'No ratings yet.')
//                ->description('Click to View Rankings')
                ->icon('heroicon-o-star')
                ->color('primary'),
            Stat::make('Top Project Manager', $top_project_manager ? $top_project_manager->name.' - '.number_format($top_project_manager->rating, 2) : 'No ratings yet.')
//                ->description('Click to View Rankings')
                ->icon('heroicon-o-star')
                ->color('primary'),
        ];
    }
}
