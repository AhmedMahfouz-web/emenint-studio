<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class ImageOptimizationService
{
    protected $manager;
    protected $maxWidth = 1920;
    protected $maxHeight = 1920;
    protected $quality = 80;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Convert uploaded image to WebP format and optimize size
     * 
     * @param UploadedFile $file
     * @param string $directory
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @param int|null $quality
     * @return string The storage path of the optimized image
     */
    public function optimizeAndConvert(
        UploadedFile $file, 
        string $directory = 'project-images',
        ?int $maxWidth = null,
        ?int $maxHeight = null,
        ?int $quality = null
    ): string {
        try {
            $maxWidth = $maxWidth ?? $this->maxWidth;
            $maxHeight = $maxHeight ?? $this->maxHeight;
            $quality = $quality ?? $this->quality;

            // Generate unique filename with .webp extension
            $filename = time() . '_' . uniqid() . '.webp';
            $relativePath = $directory . '/' . $filename;
            
            // Use Laravel's Storage facade with the public disk configuration
            $disk = Storage::disk('public');
            
            // Ensure directory exists using Storage facade
            $directoryPath = dirname($relativePath);
            if (!$disk->exists($directoryPath)) {
                $disk->makeDirectory($directoryPath);
            }

            // Load image
            $image = $this->manager->read($file->getPathname());

            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();

            // Calculate new dimensions while maintaining aspect ratio
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
                $newWidth = (int) ($originalWidth * $ratio);
                $newHeight = (int) ($originalHeight * $ratio);
                
                $image->resize($newWidth, $newHeight);
            }

            // Convert to WebP and save using Storage facade
            $webpData = $image->toWebp($quality)->toString();
            $disk->put($relativePath, $webpData);

            // Log successful conversion
            Log::info("WebP conversion successful: {$file->getClientOriginalName()} -> {$filename}");
            Log::info("Saved to storage disk: public/{$relativePath}");

            // Return the relative path for storage
            return $relativePath;
            
        } catch (\Exception $e) {
            // Log error and fallback to original file upload
            Log::error("WebP conversion failed for {$file->getClientOriginalName()}: " . $e->getMessage());
            
            // Fallback: save original file without conversion using Storage facade
            $originalExtension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $originalExtension;
            $relativePath = $directory . '/' . $filename;
            
            // Store original file using Storage facade
            $file->storeAs($directory, $filename, 'public');
            
            return $relativePath;
        }
    }

    /**
     * Process multiple images
     * 
     * @param array $files Array of UploadedFile instances
     * @param string $directory
     * @return array Array of storage paths
     */
    public function optimizeMultiple(array $files, string $directory = 'project-images'): array
    {
        $paths = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->optimizeAndConvert($file, $directory);
            }
        }
        
        return $paths;
    }

    /**
     * Delete optimized image
     * 
     * @param string $path
     * @return bool
     */
    public function deleteOptimized(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }

    /**
     * Delete multiple optimized images
     * 
     * @param array $paths
     * @return array Array of deletion results
     */
    public function deleteMultiple(array $paths): array
    {
        $results = [];
        
        foreach ($paths as $path) {
            if ($path) {
                $results[$path] = $this->deleteOptimized($path);
            }
        }
        
        return $results;
    }

    /**
     * Clean up old images when updating
     * 
     * @param string|array|null $oldImages
     * @param string|array|null $newImages
     * @return void
     */
    public function cleanupOldImages($oldImages, $newImages): void
    {
        // Convert to arrays for consistent handling
        $oldPaths = $this->normalizeImagePaths($oldImages);
        $newPaths = $this->normalizeImagePaths($newImages);
        
        // Find images that were removed
        $imagesToDelete = array_diff($oldPaths, $newPaths);
        
        // Delete the removed images
        if (!empty($imagesToDelete)) {
            $this->deleteMultiple($imagesToDelete);
        }
    }

    /**
     * Normalize image paths to array format
     * 
     * @param string|array|null $images
     * @return array
     */
    private function normalizeImagePaths($images): array
    {
        if (is_null($images)) {
            return [];
        }
        
        if (is_string($images)) {
            return [$images];
        }
        
        if (is_array($images)) {
            return array_filter($images); // Remove empty values
        }
        
        return [];
    }
}
