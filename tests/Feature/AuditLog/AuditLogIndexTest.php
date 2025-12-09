<?php

use App\Models\AuditLog;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('login user can see audit logs index', function () {
    $user = User::factory()->create();
    AuditLog::factory(5)->create();

    $response = actingAs($user)->getJson(route('audit-logs.index'));
    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            [
                'id',
                'user',
                'ip_address',
                'action',
                'model',
                'model_id',
                'changes',
            ],
        ],
    ]);
});

test('guest user can not see audit logs index', function () {
    $user = User::factory()->create();
    AuditLog::factory(5)->create();

    $response = getJson(route('audit-logs.index'));
    $response->assertUnauthorized();
});
