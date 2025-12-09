<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\deleteJson;

test('login user can delete task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->getKey()]);

    $response = actingAs($user)->deleteJson(route('tasks.destroy', $task->getKey()));
    $response->assertNoContent();

    // DB Assertions
    assertDatabaseCount('tasks', 0);
});

test('guest user can not delete task', function () {
    $task = Task::factory()->create();

    $response = deleteJson(route('tasks.destroy', $task->getKey()));
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('tasks', 1);
});
