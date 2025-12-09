<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\patchJson;

test('login user can update role', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'OLD ROLE']);
    $permission1 = Permission::query()->create(['name' => Permission::PERMISSION_TASK_VIEW]);
    $permission2 = Permission::query()->create(['name' => Permission::PERMISSION_TASK_CREATE]);

    $response = actingAs($user)->patchJson(route('role-permissions.update', $role->getKey()), [
        'name' => 'NEW ROLE',
        'permissions' => [$permission1->getKey(), $permission2->getKey()],
    ]);
    $response->assertOk();

    // DB Assertions
    assertDatabaseCount('roles', 1);
    assertDatabaseHas('roles', ['name' => 'NEW ROLE']);
    assertDatabaseMissing('roles', ['name' => 'OLD ROLE']);
});

test('guest user can not update role', function () {
    $role = Role::factory()->create(['name' => 'OLD ROLE']);

    $response = patchJson(route('role-permissions.update', $role->getKey(), [
        'name' => 'NEW ROLE',
        'permissions' => [1, 2],
    ]));
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('roles', 1);
    assertDatabaseHas('roles', ['name' => 'OLD ROLE']);
    assertDatabaseMissing('roles', ['name' => 'NEW ROLE']);
});
