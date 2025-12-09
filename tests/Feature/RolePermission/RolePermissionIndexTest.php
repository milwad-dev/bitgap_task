<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

test('login user can see roles index', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->getJson(route('role-permissions.index'));
    $response->assertOk();
});
