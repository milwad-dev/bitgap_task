<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

test('login user can delete task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    $response = actingAs($user)->delete(route('tasks.destroy', $task->getKey()));
    $response->assertNoContent();

    // DB Assertions
    assertDatabaseCount('tasks', 0);
});
