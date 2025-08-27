<?php

namespace App\Filament\Widgets;

use App\Models\Job;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JobApplicationCountPerJobWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];
        $openJobs = Job::where('status', 'open')->withCount('applications')->get();

        foreach ($openJobs as $job) {
            $stats[] = Stat::make($job->title, $job->applications_count);
        }

        return $stats;
    }
}
