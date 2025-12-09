<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\RoleStoreRequest;
use App\Http\Requests\RolePermission\RoleUpdateRequest;
use App\Http\Resources\RolePermission\RoleResource;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class RolePermissionController extends Controller
{
    /**
     * Get the latest roles and return json response.
     */
    public function index()
    {
        $roles = Cache::remember('roles', now()->addDay(), function () {
            return Role::query()->latest()->paginate();
        });

        return RoleResource::collection($roles);
    }

    /**
     * Create new role with attach permissions.
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::query()->create(['name' => $request->name]);
        $role->permissions()->attach($request->permissions);

        return new RoleResource($role);
    }

    /**
     * Find role and update it with sync permissions.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);

        return new RoleResource($role);
    }

    /**
     * Find role and delete it.
     */
    public function destroy(int $id)
    {
        Role::query()->where('id', $id)->delete();

        return response()->json(null, 204);
    }
}
