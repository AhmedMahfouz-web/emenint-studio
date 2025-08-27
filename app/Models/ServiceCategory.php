<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color_scheme',
        'icon',
        'is_active',
        'sort_order',
        'template_name',
    ];

    protected $casts = [
        'color_scheme' => 'array',
        'is_active' => 'boolean',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function templateBlocks(): HasMany
    {
        return $this->hasMany(TemplateBlock::class);
    }

    public function activeProjects(): HasMany
    {
        return $this->projects()->where('status', 'active');
    }

    public function getColorSchemeAttribute($value)
    {
        $decoded = json_decode($value, true);
        return $decoded ?: [
            'primary' => '#003bf4',
            'secondary' => '#ffffff',
            'accent' => '#f8f9fa'
        ];
    }
}
