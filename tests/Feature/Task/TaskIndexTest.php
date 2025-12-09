<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('login user can see tasks index', function () {
    $user = User::factory()->create();
    \App\Models\Task::factory(10)->create();

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
