<?php

use App\Models\Role;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

test('login user can delete role', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'OLD ROLE']);

    $response = actingAs($user)->deleteJson(route('role-permissions.destroy', $role->getKey()));
    $response->assertNoContent();

    // DB Assertions
    assertDatabaseCount('roles', 0);
    assertDatabaseMissing('roles', ['name' => 'OLD ROLE']);
});

test('guest user can not delete role', function () {
    $role = Role::factory()->create(['name' => 'OLD ROLE']);

    $response = deleteJson(route('role-permissions.destroy', $role->getKey()));
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('roles', 1);
    assertDatabaseHas('roles', ['name' => 'OLD ROLE']);
});
