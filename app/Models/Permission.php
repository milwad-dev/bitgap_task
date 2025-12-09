<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public const string PERMISSION_SUPER_ADMIN = 'super admin';

    public const string PERMISSION_TASK_VIEW = 'task view';

    public const string PERMISSION_TASK_CREATE = 'task create';

    public const string PERMISSION_TASK_UPDATE = 'task update';

    public const string PERMISSION_TASK_DELETE = 'task delete';

    public static array $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_TASK_VIEW,
        self::PERMISSION_TASK_CREATE,
        self::PERMISSION_TASK_UPDATE,
        self::PERMISSION_TASK_DELETE,
    ];
}
