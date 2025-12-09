<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuditLog\AuditLogActionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\AuditLog\AuditLogService;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SignUpRequest $request)
    {
        // Create user
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create user token
        $token = $user->createToken('token')->plainTextToken;

        // Create log
        resolve(AuditLogService::class)->store(AuditLogActionEnum::ACTION_REGISTER->value);

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token,
                'user' => new UserResource($user),
            ],
        ]);
    }
}
