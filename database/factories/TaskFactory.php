<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'description' => $this->faker->text(),
            'priority' => $this->faker->randomElement(array_column(\App\Enums\TaskPriority::cases(), 'value')),
            'completed' => $this->faker->boolean(),
            'section_id' => Section::factory(),
        ];
    }
}
