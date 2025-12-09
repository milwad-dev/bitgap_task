<?php

use App\Enums\Task\TaskStatusEnum;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

test('login user can store new task without assign', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson(route('tasks.store'), [
        'title' => 'Task Title',
        'status' => TaskStatusEnum::STATUS_PENDING->value,
        'description' => 'Task DESC',
        'due_date' => now()->addDays(30)->format('Y-m-d'),
    ]);
    $response->assertSuccessful();
    $response->assertJsonStructure([
        'data' => [
            'id',
            'title',
            'status',
            'description',
            'due_date',
            'user',
        ],
    ]);

    // DB Assertions
    assertDatabaseCount('tasks', 1);
});

test('guest user can not store new task without assign', function () {
    $response = postJson(route('tasks.store'), [
        'title' => 'Task Title',
        'status' => TaskStatusEnum::STATUS_PENDING->value,
        'description' => 'Task DESC',
        'due_date' => now()->addDays(30)->format('Y-m-d'),
    ]);
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('tasks', 0);
});
