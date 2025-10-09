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
            Actions\Action::make('add_images')
                ->label('Add Images')
                ->icon('heroicon-o-plus')
                ->color('success')
                ->action(function () {
                    // Get current max sort order
                    $maxSortOrder = $this->record->projectImages()->max('sort_order') ?? 0;
                    
                    // Add 5 empty image slots for easy upload
                    for ($i = 1; $i <= 5; $i++) {
                        ProjectImage::create([
                            'project_id' => $this->record->id,
                            'image_path' => '', // Empty path - user will upload
                            'alt_text' => 'Project Image',
                            'sort_order' => $maxSortOrder + $i,
                        ]);
                    }
                    
                    $this->refreshFormData(['projectImages']);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Image slots added')
                        ->body('5 empty image slots added. Upload images in the gallery section below.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Add Image Slots')
                ->modalDescription('This will add 5 empty image slots that you can upload images to in the gallery section below.')
                ->modalSubmitActionLabel('Add Slots'),
                
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
