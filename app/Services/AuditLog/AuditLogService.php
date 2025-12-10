<?php

namespace App\Services\AuditLog;

use App\Jobs\AuditLogStoreQueue;
use Illuminate\Database\Eloquent\Model;

class AuditLogService
{
    /**
     * Store new audit log.
     */
    public function store(string $action, ?Model $model = null, ?string $changes = null): bool
    {
        AuditLogStoreQueue::dispatch($action, $model, $changes);

        return true;
    }
}
