<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Permission::$permissions as $permission) {
            Permission::query()->firstOrCreate(['name' => $permission]);
        }

        Role::query()->firstOrCreate(['name' => 'admin'])->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
        Role::query()->firstOrCreate(['name' => 'regular user'])->givePermissionTo([
            Permission::PERMISSION_TASK_VIEW,
            Permission::PERMISSION_TASK_CREATE,
        ]);
    }
}
