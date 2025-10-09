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
            Actions\Action::make('bulk_upload')
                ->label('Bulk Upload Images')
                ->icon('heroicon-o-photo')
                ->color('success')
                ->form([
                    Forms\Components\FileUpload::make('bulk_images')
                        ->label('Select Multiple Images')
                        ->image()
                        ->multiple()
                        ->disk('public')
                        ->directory('project-images')
                        ->maxFiles(50)
                        ->panelLayout('grid')
                        ->imagePreviewHeight('120')
                        ->visibility('public')
                        ->maxSize(10240) // 10MB per file
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                        ->helperText('Select up to 50 images to upload at once. Max size: 10MB per image.')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    if (!isset($data['bulk_images']) || empty($data['bulk_images'])) {
                        \Filament\Notifications\Notification::make()
                            ->title('No images selected')
                            ->warning()
                            ->send();
                        return;
                    }
                    
                    // Get current max sort order
                    $maxSortOrder = $this->record->projectImages()->max('sort_order') ?? 0;
                    $uploadedCount = 0;
                    
                    // Create ProjectImage records for each uploaded file
                    foreach ($data['bulk_images'] as $imagePath) {
                        ProjectImage::create([
                            'project_id' => $this->record->id,
                            'image_path' => $imagePath,
                            'alt_text' => 'Project Image',
                            'sort_order' => ++$maxSortOrder,
                        ]);
                        $uploadedCount++;
                    }
                    
                    // Refresh the form to show new images
                    $this->refreshFormData(['projectImages']);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Images uploaded successfully')
                        ->body("{$uploadedCount} images added to the gallery. You can reorder them below.")
                        ->success()
                        ->send();
                })
                ->modalHeading('Bulk Upload Images')
                ->modalDescription('Select multiple images to upload at once. They will be added to the gallery where you can reorder and edit them.')
                ->modalSubmitActionLabel('Upload Images')
                ->modalWidth('2xl'),
                
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
