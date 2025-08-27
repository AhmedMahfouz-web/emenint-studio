<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->jobTitle();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'status' => $this->faker->randomElement(['draft', 'open', 'closed']),
            'published_at' => $this->faker->optional()->dateTimeThisYear(),
        ];
    }
}
