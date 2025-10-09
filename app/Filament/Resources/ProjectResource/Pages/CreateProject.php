<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Debug: Log the form data before creation
        Log::info('Project creation data:', $data);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Debug: Log the created project data
        Log::info('Project created successfully:', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'featured_image' => $this->record->featured_image,
        ]);
    }
}
