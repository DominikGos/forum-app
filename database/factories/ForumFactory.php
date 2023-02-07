<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Forum>
 */
class ForumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->randomElement(['sport', 'programming', 'music', 'painting']),
            'description' => fake()->text(100),
            'image_path' => fake()->filePath(),
            'published_at' => fake()->randomElement([null, now()]),
        ];
    }
}
