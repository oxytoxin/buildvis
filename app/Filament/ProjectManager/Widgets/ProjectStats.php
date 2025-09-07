<?php

namespace App\Filament\ProjectManager\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', auth()->user()->managed_projects()->count()),
        ];
    }
}
