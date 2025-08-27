<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Blade;

class TemplateBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'block_name',
        'block_type',
        'html_template',
        'css_styles',
        'content_schema',
        'default_content',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'content_schema' => 'array',
        'default_content' => 'array',
        'is_active' => 'boolean',
    ];

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function projectBlockContents(): HasMany
    {
        return $this->hasMany(ProjectBlockContent::class);
    }

    public function renderBlock($project, $contentData = [])
    {
        // Merge default content with project-specific content
        $data = array_merge($this->default_content ?? [], $contentData);
        $data['project'] = $project;
        
        try {
            // Process the Blade template
            return Blade::render($this->html_template, $data);
        } catch (\Exception $e) {
            return '<div class="template-error">Template rendering error: ' . $e->getMessage() . '</div>';
        }
    }

    public function getProjectsUsingCountAttribute()
    {
        return $this->projectBlockContents()->count();
    }
}
