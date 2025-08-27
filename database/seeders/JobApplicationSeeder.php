<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $openJobs = \App\Models\Job::where('status', 'open')->get();

        foreach ($openJobs as $job) {
            \App\Models\JobApplication::factory()->count(5)->create(['job_id' => $job->id]);
        }
    }
}
