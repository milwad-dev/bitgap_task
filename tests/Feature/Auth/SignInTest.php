<?php

use App\Models\User;
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
