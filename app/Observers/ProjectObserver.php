<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\ImageOptimizationService;

class ProjectObserver
{
    protected $imageOptimizer;

    public function __construct(ImageOptimizationService $imageOptimizer)
    {
        $this->imageOptimizer = $imageOptimizer;
    }

    /**
     * Handle the Project "updating" event.
     */
    public function updating(Project $project): void
    {
        // Clean up featured image if changed
        if ($project->isDirty('featured_image')) {
            $oldImage = $project->getOriginal('featured_image');
            $newImage = $project->featured_image;
            
            if ($oldImage && $oldImage !== $newImage) {
                $this->imageOptimizer->deleteOptimized($oldImage);
            }
        }

        // Clean up gallery images if changed
        if ($project->isDirty('gallery_images')) {
            $oldImages = $project->getOriginal('gallery_images') ?? [];
            $newImages = $project->gallery_images ?? [];
            
            $this->imageOptimizer->cleanupOldImages($oldImages, $newImages);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        // Delete featured image
        if ($project->featured_image) {
            $this->imageOptimizer->deleteOptimized($project->featured_image);
        }

        // Delete all gallery images
        if ($project->gallery_images && is_array($project->gallery_images)) {
            $this->imageOptimizer->deleteMultiple($project->gallery_images);
        }
    }
}
