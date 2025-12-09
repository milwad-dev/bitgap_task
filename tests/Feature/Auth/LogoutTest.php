<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('login user can logout', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->postJson(route('auth.logout'));
    $response->assertOk();
    $response->assertJson(['message' => 'Successfully logged out.']);
});

test('guest user can not logout', function () {
    $response = postJson(route('auth.logout'));
    $response->assertUnauthorized();
});
