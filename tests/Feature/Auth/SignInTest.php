<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('guest user can sign in', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = postJson(route('auth.sign-in'), [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response->assertOk();
    $response->assertJsonStructure([
        'status',
        'data' => [
            'token',
            'user' => [
                'id',
                'name',
                'email',
            ],
        ],
    ]);
});

test('login user can not sign in', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = actingAs($user, 'sanctum')->postJson(route('auth.sign-in'), [
        'email' => $user->email,
        'password' => 'password',
    ]);
    $response->assertFound();
});

test('guest user can not sign in when the user is not exists before', function () {
    $response = postJson(route('auth.sign-in'), [
        'email' => 'milwad@gmail.com',
        'password' => 'password',
    ]);
    $response->assertUnprocessable();
});

test('sign in validation work correctly', function () {
    $response = postJson(route('auth.sign-in'), []);
    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['email', 'password']);
});
