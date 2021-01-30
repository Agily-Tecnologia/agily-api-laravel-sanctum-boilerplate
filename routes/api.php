<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',  [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/logged-user', [AuthController::class, 'loggedUser']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::get('/users', [UserController::class, 'index']);
});


