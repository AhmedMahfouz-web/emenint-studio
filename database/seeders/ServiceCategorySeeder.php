<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Branding',
                'slug' => 'branding',
                'description' => 'Complete brand identity design including logos, color schemes, and brand guidelines.',
                'color_scheme' => [
                    'primary' => '#003bf4',
                    'secondary' => '#ffffff',
                    'accent' => '#f8f9fa'
                ],
                'icon' => 'heroicon-o-paint-brush',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Custom website development and web application solutions.',
                'color_scheme' => [
                    'primary' => '#10b981',
                    'secondary' => '#ffffff',
                    'accent' => '#ecfdf5'
                ],
                'icon' => 'heroicon-o-code-bracket',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Digital marketing campaigns and promotional materials.',
                'color_scheme' => [
                    'primary' => '#f59e0b',
                    'secondary' => '#ffffff',
                    'accent' => '#fffbeb'
                ],
                'icon' => 'heroicon-o-megaphone',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'E-commerce',
                'slug' => 'e-commerce',
                'description' => 'Online store development and e-commerce solutions.',
                'color_scheme' => [
                    'primary' => '#8b5cf6',
                    'secondary' => '#ffffff',
                    'accent' => '#f3f4f6'
                ],
                'icon' => 'heroicon-o-shopping-cart',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
