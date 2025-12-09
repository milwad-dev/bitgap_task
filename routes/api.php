<?php

use App\Http\Controllers\Auth\SignUpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// SignUp
Route::post('sign-up', SignUpController::class)->middleware('guest:sanctum');
