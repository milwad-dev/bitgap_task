<?php

namespace App\Services\AuditLog;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogService
{
    /**
     * Store new audit log.
     */
    public function store(string $action, ?Model $model = null, ?string $changes = null): AuditLog
    {
        return AuditLog::query()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'model' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'changes' => $changes,
        ]);
    }
}
