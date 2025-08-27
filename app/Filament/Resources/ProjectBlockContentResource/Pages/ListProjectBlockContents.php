<?php

namespace App\Filament\Resources\ProjectBlockContentResource\Pages;

use App\Filament\Resources\ProjectBlockContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectBlockContents extends ListRecords
{
    protected static string $resource = ProjectBlockContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
