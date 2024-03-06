<?php

namespace Database\Factories;

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
            'name' => $this->faker->name,
            'user_id' => '2b4c794e-dad7-11ee-a294-0242ac140003',
            'year_month' => $this->faker->year . $this->faker->month,
            'course_fee' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
