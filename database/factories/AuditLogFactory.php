<?php

namespace Database\Factories;

use App\Enums\AuditLog\AuditLogActionEnum;
use App\Models\AuditLog;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    protected $model = AuditLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'ip_address' => $this->faker->ipv4,
            'action' => AuditLogActionEnum::ACTION_READ->value,
            'model' => Task::class,
            'model_id' => Task::factory(),
        ];
    }
}
