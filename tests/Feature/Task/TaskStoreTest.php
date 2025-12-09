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

test('store task validation work correctly', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson(route('tasks.store'), []);
    $response->assertUnprocessable();
    $response->assertOnlyJsonValidationErrors([
        'title',
        'status',
        'description',
        'due_date',
    ]);

    // DB Assertions
    assertDatabaseCount('tasks', 0);
});

test('login user can store new task with assign', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson(route('tasks.store'), [
        'title' => 'Task Title',
        'status' => TaskStatusEnum::STATUS_PENDING->value,
        'description' => 'Task DESC',
        'due_date' => now()->addDays(30)->format('Y-m-d'),
        'assigned_id' => User::factory()->create(['email' => 'assign@gmail.com'])->getKey(),
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
            'assigned',
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
