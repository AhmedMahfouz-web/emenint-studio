<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class ProjectObserver
{
    protected $optimizationService;

    public function __construct(ImageOptimizationService $optimizationService)
    {
        $this->optimizationService = $optimizationService;
    }

    public function saving(Project $project): void
    {
        if ($project->isDirty('featured_image') && $project->featured_image instanceof UploadedFile) {
            $this->deleteImageSet($project->getOriginal('featured_image'));
            $project->featured_image = $this->optimizationService->processUpload($project->featured_image);
        }

        if ($project->isDirty('gallery_images') && is_array($project->gallery_images)) {
            $originalGallery = $project->getOriginal('gallery_images') ?? [];
            $newGallery = [];
            $keptImageOriginalPaths = [];

            foreach ($project->gallery_images as $image) {
                if ($image instanceof UploadedFile) {
                    $newGallery[] = $this->optimizationService->processUpload($image);
                } else {
                    $imageData = is_string($image) ? json_decode($image, true) : $image;
                    if (is_array($imageData) && isset($imageData['original'])) {
                        $newGallery[] = $imageData;
                        $keptImageOriginalPaths[] = $imageData['original'];
                    }
                }
            }

            foreach ($originalGallery as $oldImage) {
                $oldImageData = is_string($oldImage) ? json_decode($oldImage, true) : $oldImage;
                if (is_array($oldImageData) && isset($oldImageData['original']) && !in_array($oldImageData['original'], $keptImageOriginalPaths)) {
                    $this->deleteImageSet($oldImageData);
                }
            }

            $project->gallery_images = $newGallery;
        }
    }

    public function deleted(Project $project): void
    {
        $this->deleteImageSet($project->featured_image);
        if (is_array($project->gallery_images)) {
            foreach ($project->gallery_images as $image) {
                $this->deleteImageSet($image);
            }
        }
    }

    protected function deleteImageSet($imageSet): void
    {
        if (empty($imageSet)) return;

        $imageData = is_string($imageSet) ? json_decode($imageSet, true) : $imageSet;
        if (!is_array($imageData)) return;

        $filesToDelete = [];
        $filesToDelete[] = Arr::get($imageData, 'original');
        $filesToDelete = array_merge($filesToDelete, array_values(Arr::get($imageData, 'webp', [])));
        $filesToDelete = array_merge($filesToDelete, array_values(Arr::get($imageData, 'jpeg', [])));

        foreach ($filesToDelete as $fileUrl) {
            if ($fileUrl) {
                $path = str_replace(Storage::url(''), '', $fileUrl);
                Storage::disk('public')->delete($path);
            }
        }
    }
}
