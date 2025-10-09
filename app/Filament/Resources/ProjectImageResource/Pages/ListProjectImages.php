<?php

namespace App\Filament\Resources\ProjectImageResource\Pages;

use App\Filament\Resources\ProjectImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectImages extends ListRecords
{
    protected static string $resource = ProjectImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('gallery_manager')
                ->label('Gallery Manager')
                ->icon('heroicon-o-photo')
                ->color('info')
                ->url(fn (): string => static::getResource()::getUrl('gallery')),
        ];
    }
}
