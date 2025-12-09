<?php

namespace App\Enums\AuditLog;

enum AuditLogActionEnum: string
{
    case ACTION_READ = 'read';
    case ACTION_CREATE = 'create';
    case ACTION_UPDATE = 'update';
    case ACTION_DELETE = 'delete';
    case ACTION_LOGOUT = 'logout';
    case ACTION_LOGIN = 'login';
    case ACTION_REGISTER = 'register';
}
