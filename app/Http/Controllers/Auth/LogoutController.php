<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuditLog\AuditLogActionEnum;
use App\Http\Controllers\Controller;
use App\Services\AuditLog\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Logout the logged user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Delete all user tokens
        $request->user()->tokens()->delete();

        // Create log
        resolve(AuditLogService::class)->store(AuditLogActionEnum::ACTION_LOGOUT->value);

        return response()->json(['message' => 'Successfully logged out.']);
    }
}
