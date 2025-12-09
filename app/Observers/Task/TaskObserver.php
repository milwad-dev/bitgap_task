<?php

namespace App\Observers\Task;

use App\Enums\AuditLog\AuditLogActionEnum;
use App\Models\Task;
use App\Services\AuditLog\AuditLogService;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        resolve(AuditLogService::class)->store(
            AuditLogActionEnum::ACTION_CREATE->value,
            $task,
        );
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        resolve(AuditLogService::class)->store(
            AuditLogActionEnum::ACTION_UPDATE->value,
            $task,
        );
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        resolve(AuditLogService::class)->store(
            AuditLogActionEnum::ACTION_DELETE->value,
            $task,
        );
    }
}
