<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function projectImages(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function featuredProjectImage()
    {
        return $this->hasOne(ProjectImage::class)->where('is_featured', true);
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
     * Get gallery image URLs (Legacy)
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
     * Get sorted project image URLs
     */
    public function getSortedProjectImagesAttribute()
    {
        return $this->projectImages()->ordered()->get();
    }

    /**
     * Get project image URLs as array
     */
    public function getProjectImageUrlsAttribute(): array
    {
        return $this->projectImages()->ordered()->get()->map(function ($image) {
            return $image->image_url;
        })->toArray();
    }

    // Basic model - no complex image processing for now
}
