<?php

namespace App\Jobs;

use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;

class AuditLogStoreQueue implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $action,
        public ?Model $model = null,
        public ?string $changes = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        AuditLog::query()->create([
            'user_id' => auth()->id(),
            'action' => $this->action,
            'ip_address' => request()->ip(),
            'model' => $this->model ? get_class($this->model) : null,
            'model_id' => $this->model?->getKey(),
            'changes' => $this->changes,
        ]);
    }
}
