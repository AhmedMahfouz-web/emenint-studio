<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Job::create([
            'title' => 'Senior Laravel Developer',
            'slug' => Str::slug('Senior Laravel Developer'),
            'location' => 'Remote',
            'type' => 'Full-time',
            'description' => 'We are looking for an experienced Laravel developer to join our team.',
            'status' => 'open',
        ]);

        \App\Models\Job::create([
            'title' => 'Frontend Developer (Vue.js)',
            'slug' => Str::slug('Frontend Developer (Vue.js)'),
            'location' => 'New York, NY',
            'type' => 'Full-time',
            'description' => 'Seeking a talented Frontend Developer with Vue.js experience.',
            'status' => 'open',
        ]);

        \App\Models\Job::create([
            'title' => 'UI/UX Designer',
            'slug' => Str::slug('UI/UX Designer'),
            'location' => 'Remote',
            'type' => 'Contract',
            'description' => 'We need a creative UI/UX designer for a 3-month project.',
            'status' => 'closed',
        ]);
    }
}
