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
        'featured_image' => 'array',
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
}
