<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user-profiles', [UserController::class, 'userProfiles']);


Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'me']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);    
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::get('/destinations', [OrderController::class, 'destinations']);
});
