<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\RolePermission\RolePermissionController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// SignUp
Route::post('sign-up', SignUpController::class)
    ->name('auth.sign-up')
    ->middleware('guest:sanctum');

// SignIn
Route::post('sign-in', SignInController::class)
    ->name('auth.sign-in')
    ->middleware('guest:sanctum');

Route::middleware('auth:sanctum')->group(function ($router) {
    // Logout
    $router->post('logout', LogoutController::class)->name('auth.logout');

    // Role-Permission
    $router->get('role-permissions', [RolePermissionController::class, 'index'])
        ->name('role-permissions.index');

    $router->post('role-permissions', [RolePermissionController::class, 'store'])
        ->name('role-permissions.store');

    $router->patch('role-permissions/{role}', [RolePermissionController::class, 'update'])
        ->where('role', '[0-9]+')
        ->name('role-permissions.update');

    $router->delete('role-permissions/{id}', [RolePermissionController::class, 'destroy'])
        ->where('role', '[0-9]+')
        ->name('role-permissions.destroy');

    // Task
    $router->apiResource('tasks', TaskController::class);
});
