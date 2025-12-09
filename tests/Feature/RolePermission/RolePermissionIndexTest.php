<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('login user can see roles index', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->getJson(route('role-permissions.index'));
    $response->assertOk();
});

test('guest user can not see roles index', function () {
    $response = getJson(route('role-permissions.index'));
    $response->assertUnauthorized();
});
