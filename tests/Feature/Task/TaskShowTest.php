<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('login user can see single task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->getKey()]);

    $response = actingAs($user)->getJson(route('tasks.show', $task->getKey()));
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
});

test('guest user can not see single task', function () {
    $task = Task::factory()->create();

    $response = getJson(route('tasks.show', $task->getKey()));
    $response->assertUnauthorized();
});
