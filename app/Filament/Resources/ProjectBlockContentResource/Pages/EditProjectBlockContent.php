<?php

namespace App\Filament\Resources\ProjectBlockContentResource\Pages;

use App\Filament\Resources\ProjectBlockContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectBlockContent extends EditRecord
{
    protected static string $resource = ProjectBlockContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
