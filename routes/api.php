<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user-profiles', [UserController::class, 'userProfiles']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
