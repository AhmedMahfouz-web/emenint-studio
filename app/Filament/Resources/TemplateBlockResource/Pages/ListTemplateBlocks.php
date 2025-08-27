<?php

namespace App\Filament\Resources\TemplateBlockResource\Pages;

use App\Filament\Resources\TemplateBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemplateBlocks extends ListRecords
{
    protected static string $resource = TemplateBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
