<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('login user can see tasks index', function () {
    $user = User::factory()->create();
    Task::factory(5)->create(['user_id' => $user->getKey()]);
    Task::factory(5)->create(['assigned_id' => $user->getKey()]);

    $response = actingAs($user)->getJson(route('tasks.index'));
    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            [
                'id',
                'title',
                'status',
                'description',
                'due_date',
                'user',
            ],
        ],
    ]);
});

test('guest user can not see tasks index', function () {
    $response = getJson(route('tasks.index'));
    $response->assertUnauthorized();
});
