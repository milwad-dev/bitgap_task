<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

test('guest user can sign up', function () {
    $response = postJson(route('auth.sign-up'), [
        'name' => 'Milwad Khosravi',
        'email' => 'milwad@gmail.com',
        'password' => 'Milwad123!',
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

    // DB Assertions
    assertDatabaseCount('users', 1);
});

test('login user can not sign up', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);

    $response = actingAs($user, 'sanctum')->postJson(route('auth.sign-up'), [
        'name' => 'Milwad Khosravi',
        'email' => 'milwad@gmail.com',
        'password' => 'Milwad123!',
    ]);
    $response->assertFound();
});

test('guest user can not sign up when the user is exists before', function () {
    $user = User::factory()->create(['password' => Hash::make('Milwad123!')]);

    $response = postJson(route('auth.sign-up'), [
        'email' => $user->email,
        'password' => 'Milwad123!',
    ]);
    $response->assertUnprocessable();
});

test('sign up validation work correctly', function () {
    $response = postJson(route('auth.sign-up'), []);
    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name', 'email', 'password']);
});
