<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageOptimizationService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function processUpload(UploadedFile $uploadedFile, array $options = []): array
    {
        $results = [];
        
        // 1. Store original file
        $originalPath = $this->storeOriginal($uploadedFile);
        $results['original'] = $originalPath;
        
        // 2. Generate WebP versions
        $webpVersions = $this->generateWebPVersions($originalPath);
        $results['webp'] = $webpVersions;
        
        // 3. Generate JPEG fallbacks
        $jpegVersions = $this->generateJPEGVersions($originalPath);
        $results['jpeg'] = $jpegVersions;
        
        // 4. Calculate metadata
        $results['metadata'] = $this->calculateMetadata($uploadedFile, $results);
        
        return $results;
    }

    protected function storeOriginal(UploadedFile $file): string
    {
        $filename = time() . '_' . uniqid() . '_original.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('projects/images/originals', $filename, 'public');
        return Storage::url($path);
    }

    protected function generateWebPVersions(string $originalPath): array
    {
        $versions = [];
        $sizes = config('image-optimization.sizes');
        
        foreach ($sizes as $sizeName => $dimensions) {
            if ($sizeName === 'original') {
                continue;
            }
            
            $webpPath = $this->resizeAndConvert($originalPath, $dimensions, 'webp', $sizeName);
            $versions[$sizeName] = $webpPath;
        }
        
        return $versions;
    }

    protected function generateJPEGVersions(string $originalPath): array
    {
        $versions = [];
        $sizes = config('image-optimization.sizes');
        
        foreach ($sizes as $sizeName => $dimensions) {
            if ($sizeName === 'original') {
                continue;
            }
            
            $jpegPath = $this->resizeAndConvert($originalPath, $dimensions, 'jpeg', $sizeName);
            $versions[$sizeName] = $jpegPath;
        }
        
        return $versions;
    }

    protected function resizeAndConvert(string $originalPath, array $dimensions, string $format, string $sizeName): string
    {
        // Convert URL back to storage path
        $storagePath = str_replace('/storage/', '', $originalPath);
        $fullPath = storage_path('app/public/' . $storagePath);
        
        // Load and resize image
        $image = $this->manager->read($fullPath);
        
        if ($dimensions) {
            $image->resize($dimensions['width'], $dimensions['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        
        // Generate filename
        $filename = time() . '_' . uniqid() . '_' . $sizeName . '.' . $format;
        $directory = 'projects/images/' . $format;
        $relativePath = $directory . '/' . $filename;
        $fullOutputPath = storage_path('app/public/' . $relativePath);
        
        // Ensure directory exists
        if (!file_exists(dirname($fullOutputPath))) {
            mkdir(dirname($fullOutputPath), 0755, true);
        }
        
        // Save with appropriate quality
        if ($format === 'webp') {
            $image->toWebp(config('image-optimization.formats.webp.quality'))->save($fullOutputPath);
        } else {
            $image->toJpeg(config('image-optimization.formats.jpeg.quality'))->save($fullOutputPath);
        }
        
        return Storage::url($relativePath);
    }

    protected function calculateMetadata(UploadedFile $originalFile, array $results): array
    {
        $originalSize = $originalFile->getSize();
        
        // Calculate optimized size (approximate)
        $optimizedSize = 0;
        foreach ($results['webp'] as $webpPath) {
            $storagePath = str_replace('/storage/', '', $webpPath);
            $fullPath = storage_path('app/public/' . $storagePath);
            if (file_exists($fullPath)) {
                $optimizedSize += filesize($fullPath);
            }
        }
        
        $compressionRatio = $originalSize > 0 ? (($originalSize - $optimizedSize) / $originalSize) * 100 : 0;
        
        return [
            'original_size' => $this->formatBytes($originalSize),
            'optimized_size' => $this->formatBytes($optimizedSize),
            'compression_ratio' => round($compressionRatio, 1) . '%',
            'dimensions' => getimagesize($originalFile->getPathname()) ?: ['width' => 0, 'height' => 0],
        ];
    }

    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
