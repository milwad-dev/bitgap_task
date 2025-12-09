<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuditLog\AuditLogActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\AuditLog\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignInController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SignInRequest $request)
    {
        // Find user by email
        $user = User::query()->where('email', $request->email)->firstOrFail();

        // Check passwords are equal
        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials',
            ], 422);
        }

        // Create user token
        $token = $user->createToken('token')->plainTextToken;

        // Create log
        resolve(AuditLogService::class)->store(AuditLogActionEnum::ACTION_LOGIN->value);

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token,
                'user' => new UserResource($user),
            ],
        ]);
    }
}
