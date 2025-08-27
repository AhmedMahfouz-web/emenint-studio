<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'cover_letter' => $this->faker->paragraph(),
            'resume_path' => 'resumes/dummy.pdf',
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
