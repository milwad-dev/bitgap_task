<?php

namespace App\Enums\Task;

enum TaskStatusEnum: string
{
    case STATUS_PENDING = 'pending';
    case STATUS_COMPLETED = 'completed';
}
