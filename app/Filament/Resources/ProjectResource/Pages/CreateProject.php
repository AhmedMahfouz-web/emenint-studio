<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\ProjectImage;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Log;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
    
    protected array $bulkImages = [];

    protected function getHeaderActions(): array
    {
        return [
            // Bulk upload action moved to form section
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            Actions\Action::make('bulk_upload_modal')
                ->label('Bulk Upload Images')
                ->icon('heroicon-o-arrow-up-tray')
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
                        ->maxSize(20480) // 20MB per file
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                        ->helperText('Select up to 50 images to upload at once (max 20MB each). Images will be automatically optimized to WebP format.')
                        ->saveUploadedFileUsing(function (UploadedFile $file, $component) {
                            try {
                                $optimizer = app(ImageOptimizationService::class);
                                return $optimizer->optimizeAndConvert($file, 'project-images', 1920, 1920, 80);
                            } catch (\Exception $e) {
                                Log::error('Bulk image optimization failed: ' . $e->getMessage());
                                // Fallback to normal upload
                                $filename = time() . '_' . $file->hashName();
                                return $file->storeAs('project-images', $filename, 'public');
                            }
                        })
                        ->required()
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    // Check if we have a valid record
                    if ($this->record === null) {
                        \Filament\Notifications\Notification::make()
                            ->title('Project not created yet')
                            ->body('Please create the project first before uploading images.')
                            ->danger()
                            ->send();
                        return;
                    }
                    
                    if (!isset($data['bulk_images']) || empty($data['bulk_images'])) {
                        \Filament\Notifications\Notification::make()
                            ->title('No images selected')
                            ->warning()
                            ->send();
                        return;
                    }
                    
                    // Wait a moment for the project to be fully created
                    usleep(500000); // 0.5 seconds
                    
                    // Refresh the record to ensure we have the latest data
                    $this->record->refresh();
                    
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
                ->modalWidth('2xl')
                ->visible(false), // Hidden action that can be triggered from form
        ];
    }

    public function openBulkUploadModal(): void
    {
        // Mount the hidden bulk upload modal action
        $this->mountAction('bulk_upload_modal');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Debug: Log the form data before creation
        Log::info('Project creation data:', $data);
        
        // Get bulk images from the form state directly
        $formState = $this->form->getState();
        if (isset($formState['bulk_images']) && is_array($formState['bulk_images'])) {
            $this->bulkImages = array_filter($formState['bulk_images']); // Remove any null/empty values
            Log::info('Bulk images found in form state:', ['count' => count($this->bulkImages), 'paths' => $this->bulkImages]);
        }
        
        // Remove bulk_images from project data if it exists
        if (isset($data['bulk_images'])) {
            unset($data['bulk_images']);
        }
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Handle bulk images if any were uploaded
        Log::info('After create - checking bulk images:', ['count' => count($this->bulkImages), 'images' => $this->bulkImages]);
        
        if (!empty($this->bulkImages)) {
            $uploadedCount = 0;
            $sortOrder = 0;
            
            // Create ProjectImage records for each uploaded file
            foreach ($this->bulkImages as $imagePath) {
                Log::info('Processing bulk image:', ['path' => $imagePath, 'empty' => empty($imagePath), 'type' => gettype($imagePath)]);
                if (!empty($imagePath) && is_string($imagePath)) { // Make sure the path is not null or empty and is a string
                    try {
                        \App\Models\ProjectImage::create([
                            'project_id' => $this->record->id,
                            'image_path' => $imagePath,
                            'alt_text' => 'Project Image',
                            'sort_order' => $sortOrder++,
                        ]);
                        $uploadedCount++;
                        Log::info('Successfully created ProjectImage:', ['path' => $imagePath]);
                    } catch (\Exception $e) {
                        Log::error('Failed to create ProjectImage:', ['path' => $imagePath, 'error' => $e->getMessage()]);
                    }
                } else {
                    Log::warning('Skipping invalid image path:', ['path' => $imagePath, 'type' => gettype($imagePath)]);
                }
            }
            
            if ($uploadedCount > 0) {
                \Filament\Notifications\Notification::make()
                    ->title('Images uploaded successfully')
                    ->body("{$uploadedCount} images added to the gallery.")
                    ->success()
                    ->send();
            } else {
                Log::warning('No valid image paths found for bulk upload');
            }
        } else {
            Log::info('No bulk images to process');
        }
        
        // Debug: Log the created project data
        Log::info('Project created successfully:', [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'featured_image' => $this->record->featured_image,
            'bulk_images_count' => count($this->bulkImages),
        ]);
        
        // Notify user about project creation
        \Filament\Notifications\Notification::make()
            ->title('Project created successfully!')
            ->body('You can now use the "Bulk Upload Images" button to upload more images if needed.')
            ->success()
            ->send();
    }
}
