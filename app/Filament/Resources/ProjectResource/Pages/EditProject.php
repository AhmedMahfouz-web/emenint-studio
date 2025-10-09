<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\ProjectImage;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use App\Services\ImageOptimizationService;

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
                        ->multiple()
                        ->disk('public')
                        ->directory('project-images')
                        ->maxFiles(50)
                        ->reorderable()
                        ->panelLayout('grid')
                        ->imagePreviewHeight('120')
                        ->saveUploadedFileUsing(function (UploadedFile $file, $component) {
                            $optimizer = app(ImageOptimizationService::class);
                            return $optimizer->optimizeAndConvert($file, 'project-images');
                        })
                        ->helperText('Upload up to 50 images at once')
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
                ->modalHeading('Bulk Upload Images')
                ->modalDescription('Upload multiple images at once. You can reorder them in the gallery section below.')
                ->modalSubmitActionLabel('Upload Images')
                ->successNotificationTitle('Images uploaded successfully'),
                
            Actions\DeleteAction::make(),
        ];
    }
}
