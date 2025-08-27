<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
        use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'type',
        'salary_range',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
