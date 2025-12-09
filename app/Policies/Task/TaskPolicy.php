<?php

namespace App\Policies\Task;

use App\Models\Permission;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Check user has permission to view task.
     */
    public function view(User $user, Task $task): bool
    {
        return $task->user_id === $user->getKey()
            || $task->assigned_id === $user->getKey()
            || $user->hasAnyPermission(Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_TASK_VIEW);
    }

    /**
     * Check user has permission to update task.
     */
    public function update(User $user, Task $task): bool
    {
        return $task->user_id === $user->getKey()
            || $task->assigned_id === $user->getKey()
            || $user->hasAnyPermission(Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_TASK_UPDATE);
    }

    /**
     * Check user has permission to delete task.
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->user_id === $user->getKey()
            || $task->assigned_id === $user->getKey()
            || $user->hasAnyPermission(Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_TASK_DELETE);
    }
}
