<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course' => fake()->unique()->words(2, true),
            'deskripsi' => fake()->paragraph(),
            'start_date' => '2023-12-01',
            'end_date' => '2023-12-31',
            'user_id' => User::factory()->guru(),
        ];
    }
}
