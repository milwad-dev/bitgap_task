<?php

namespace Database\Factories;

use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'status' => TaskStatusEnum::STATUS_PENDING->value,
            'description' => $this->faker->text,
            'due_date' => now()->addDay(),
        ];
    }
}
