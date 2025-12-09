<?php

use App\Models\Permission;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

test('login user can store new role', function () {
    $user = User::factory()->create();
    $permission1 = Permission::query()->create(['name' => Permission::PERMISSION_TASK_VIEW]);
    $permission2 = Permission::query()->create(['name' => Permission::PERMISSION_TASK_CREATE]);

    $response = actingAs($user)->postJson(route('role-permissions.store', [
        'name' => 'NEW ROLE',
        'permissions' => [$permission1->getKey(), $permission2->getKey()],
    ]));
    $response->assertCreated();

    // DB Assertions
    assertDatabaseCount('roles', 1);
});

test('guest user can not store new role', function () {
    $response = postJson(route('role-permissions.store', [
        'name' => 'NEW ROLE',
        'permissions' => [1, 2]
    ]));
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('roles', 0);
});
