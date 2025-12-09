<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuditLog\AuditLogResource;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $logs = AuditLog::query()->latest()->paginate(30);

        return AuditLogResource::collection($logs);
    }
}
