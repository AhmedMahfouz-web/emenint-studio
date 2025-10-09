<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Seeder;

class ProjectImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This seeder is for demonstration purposes
        // It will create sample project images for existing projects
        
        $projects = Project::limit(3)->get();
        
        foreach ($projects as $project) {
            // Create 3-5 sample images per project
            $imageCount = rand(3, 5);
            
            for ($i = 1; $i <= $imageCount; $i++) {
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => 'project-images/sample-image-' . $i . '.webp',
                    'alt_text' => $project->title . ' - Image ' . $i,
                    'caption' => 'Sample caption for image ' . $i . ' of ' . $project->title,
                    'sort_order' => $i,
                    'is_featured' => $i === 1, // First image is featured
                ]);
            }
        }
    }
}
