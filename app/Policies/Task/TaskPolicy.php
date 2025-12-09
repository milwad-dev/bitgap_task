<?php

namespace App\Policies\Task;

use App\Models\Permission;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Check user has permission.
     */
    public function view(User $user, Task $task): bool
    {
        return $task->user_id === $user->getKey()
            || $task->assigned_id === $user->getKey()
            || $user->hasAnyPermission(Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_TASK_VIEW);
    }
}
