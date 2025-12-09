<?php

use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\patchJson;

test('login user can update new task without assign', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['title' => 'OLD TASK TITLE', 'user_id' => $user->getKey()]);

    $response = actingAs($user)->patchJson(route('tasks.update', $task->getKey()), [
        'title' => 'NEW TASK TITLE',
        'status' => TaskStatusEnum::STATUS_PENDING->value,
        'description' => 'Task DESC',
        'due_date' => now()->addDays(30)->format('Y-m-d'),
    ]);
    $response->assertOk();
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
    assertDatabaseHas('tasks', ['title' => 'NEW TASK TITLE']);
    assertDatabaseMissing('tasks', ['title' => 'OLD TASK TITLE']);
});

test('update task validation work correctly', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['title' => 'OLD TASK TITLE', 'user_id' => $user->getKey()]);

    $response = actingAs($user)->patchJson(route('tasks.update', $task->getKey()), []);
    $response->assertUnprocessable();
    $response->assertOnlyJsonValidationErrors([
        'title',
        'status',
        'description',
        'due_date',
    ]);

    // DB Assertions
    assertDatabaseCount('tasks', 1);
    assertDatabaseHas('tasks', ['title' => 'OLD TASK TITLE']);
});

test('login user can update new task with assign', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['title' => 'OLD TASK TITLE', 'assigned_id' => $user->getKey()]);

    $response = actingAs($user)->patchJson(route('tasks.update', $task->getKey()), [
        'title' => 'NEW TASK TITLE',
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
    assertDatabaseHas('tasks', ['title' => 'NEW TASK TITLE']);
    assertDatabaseMissing('tasks', ['title' => 'OLD TASK TITLE']);
});

test('guest user can not update new task without assign', function () {
    $task = Task::factory()->create(['title' => 'OLD TASK TITLE']);

    $response = patchJson(route('tasks.update', $task->getKey()), [
        'title' => 'NEW TASK TITLE',
        'status' => TaskStatusEnum::STATUS_PENDING->value,
        'description' => 'Task DESC',
        'due_date' => now()->addDays(30)->format('Y-m-d'),
    ]);
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('tasks', 1);

    assertDatabaseMissing('tasks', ['title' => 'NEW TASK TITLE']);
    assertDatabaseHas('tasks', ['title' => 'OLD TASK TITLE']);
});
