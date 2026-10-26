<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'user_id' => fn (array $attributes) => Course::find($attributes['course_id'])->user_id,
            'title' => fake()->unique()->words(3, true),
            'content' => fake()->paragraphs(2, true),
            'youtube_link' => 'https://youtu.be/dQw4w9WgXcQ',
        ];
    }
}
