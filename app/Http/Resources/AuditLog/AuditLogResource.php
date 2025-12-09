<?php

namespace App\Http\Resources\AuditLog;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'ip_address' => $this->ip_address,
            'action' => $this->action,
            'model' => $this->model,
            'model_id' => $this->model_id, // Can fetch model from DB and show details
            'changes' => $this->changes,
        ];
    }
}
