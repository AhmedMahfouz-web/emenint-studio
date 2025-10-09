<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\ProjectImage;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Log;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('bulk_upload_images')
                ->label('Bulk Upload Images')
                ->icon('heroicon-o-photo')
                ->color('primary')
                ->form([
                    Forms\Components\FileUpload::make('images')
                        ->label('Select Images')
                        ->image()
                        ->multiple(true) // Explicitly multiple files
                        ->disk('public')
                        ->directory('project-images')
                        ->maxFiles(50)
                        ->reorderable()
                        ->panelLayout('grid')
                        ->imagePreviewHeight('120')
                        ->visibility('public')
                        ->maxSize(10240) // 10MB per file
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                        ->helperText('Upload up to 50 images at once. Max size: 10MB per image.')
                        ->required(),
                ])
                ->action(function (array $data) {
                    if (!isset($data['images'])) {
                        return;
                    }
                    
                    $maxSortOrder = $this->record->projectImages()->max('sort_order') ?? 0;
                    
                    foreach ($data['images'] as $imagePath) {
                        ProjectImage::create([
                            'project_id' => $this->record->id,
                            'image_path' => $imagePath,
                            'alt_text' => 'Project Image',
                            'sort_order' => ++$maxSortOrder,
                        ]);
                    }
                    
                    $this->refreshFormData(['projectImages']);
                })
                ->modalDescription('Upload multiple images at once. You can reorder them in the gallery section below.')
                ->modalSubmitActionLabel('Upload Images')
                ->successNotificationTitle('Images uploaded successfully'),
                
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Debug: Log the form data before saving
        Log::info('Project update data:', $data);
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Debug: Log the updated project data
        Log::info('Project updated successfully:', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'featured_image' => $this->record->featured_image,
        ]);
    }
}
