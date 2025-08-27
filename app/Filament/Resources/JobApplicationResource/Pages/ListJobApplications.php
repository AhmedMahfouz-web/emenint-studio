<?php

namespace App\Filament\Resources\JobApplicationResource\Pages;

use App\Filament\Resources\JobApplicationResource;
use App\Filament\Widgets\JobApplicationCountPerJobWidget;
use App\Filament\Widgets\JobApplicationStatsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobApplications extends ListRecords
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            JobApplicationStatsWidget::class,
            JobApplicationCountPerJobWidget::class,
        ];
    }
}
