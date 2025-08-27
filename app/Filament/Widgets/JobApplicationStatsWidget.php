<?php

namespace App\Filament\Widgets;

use App\Models\Job;
use App\Models\JobApplication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JobApplicationStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [
            Stat::make('Total Applications', JobApplication::count()),
            Stat::make('Pending Applications', JobApplication::where('status', 'pending')->count()),
            Stat::make('Accepted Applications', JobApplication::where('status', 'accepted')->count()),
            Stat::make('Rejected Applications', JobApplication::where('status', 'rejected')->count()),
        ];

        return $stats;
    }
}
