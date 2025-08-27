<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectBlockContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'template_block_id',
        'content_data',
        'custom_css',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'content_data' => 'array',
        'is_visible' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function templateBlock(): BelongsTo
    {
        return $this->belongsTo(TemplateBlock::class);
    }

    public function render()
    {
        return $this->templateBlock->renderBlock($this->project, $this->content_data);
    }
}
