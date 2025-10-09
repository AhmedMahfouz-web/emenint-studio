<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\ProjectImage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure the project_images table exists
        if (!Schema::hasTable('project_images')) {
            return;
        }

        // Migrate existing gallery_images to project_images table
        Project::whereNotNull('gallery_images')->chunk(100, function ($projects) {
            foreach ($projects as $project) {
                if (is_array($project->gallery_images) && !empty($project->gallery_images)) {
                    $sortOrder = 1;
                    foreach ($project->gallery_images as $imagePath) {
                        ProjectImage::create([
                            'project_id' => $project->id,
                            'image_path' => $imagePath,
                            'alt_text' => $project->title . ' - Image ' . $sortOrder,
                            'sort_order' => $sortOrder,
                            'is_featured' => false,
                        ]);
                        $sortOrder++;
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all project images that were migrated
        ProjectImage::whereNotNull('project_id')->delete();
    }
};
