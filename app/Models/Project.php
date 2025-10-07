<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'project_summary',
        'challenge',
        'solution',
        'results',
        'client_name',
        'project_date',
        'completion_date',
        'duration',
        'project_url',
        'status',
        'featured_image',
        'gallery_images',
        'technologies_used',
        'services_provided',
        'is_featured',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'project_date' => 'date',
        'completion_date' => 'date',
        'gallery_images' => 'array',
        'technologies_used' => 'array',
        'services_provided' => 'array',
    ];

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function blockContents(): HasMany
    {
        return $this->hasMany(ProjectBlockContent::class)->orderBy('sort_order');
    }

    public function visibleBlockContents(): HasMany
    {
        return $this->blockContents()->where('is_visible', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSeoTitleAttribute()
    {
        return $this->seo_meta['title'] ?? $this->title;
    }

    public function getSeoDescriptionAttribute()
    {
        return $this->seo_meta['description'] ?? $this->description;
    }

    public function getSeoKeywordsAttribute()
    {
        return $this->seo_meta['keywords'] ?? '';
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (!$this->featured_image) {
            return null;
        }
        
        return asset('storage/' . $this->featured_image);
    }

    /**
     * Get gallery image URLs
     */
    public function getGalleryImageUrlsAttribute(): array
    {
        if (!$this->gallery_images || !is_array($this->gallery_images)) {
            return [];
        }
        
        return array_map(function ($image) {
            return asset('storage/' . $image);
        }, $this->gallery_images);
    }

    /**
     * Set featured image attribute with optimization
     */
    public function setFeaturedImageAttribute($value)
    {
        if ($value instanceof \Illuminate\Http\UploadedFile) {
            $optimizer = app(\App\Services\ImageOptimizationService::class);
            $this->attributes['featured_image'] = $optimizer->optimizeAndConvert(
                $value,
                'project-images',
                1920,
                1920,
                80
            );
        } else {
            $this->attributes['featured_image'] = $value;
        }
    }

    /**
     * Set gallery images attribute with optimization
     */
    public function setGalleryImagesAttribute($value)
    {
        if (is_array($value)) {
            $optimizer = app(\App\Services\ImageOptimizationService::class);
            $optimizedPaths = [];
            
            foreach ($value as $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    // Optimize and convert to WebP
                    $optimizedPaths[] = $optimizer->optimizeAndConvert(
                        $file,
                        'project-images/gallery',
                        1920,
                        1920,
                        80
                    );
                } elseif (is_string($file)) {
                    // Keep existing file paths
                    $optimizedPaths[] = $file;
                }
            }
            
            $this->attributes['gallery_images'] = json_encode($optimizedPaths);
        } else {
            $this->attributes['gallery_images'] = $value;
        }
    }
}
