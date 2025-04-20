<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// Route::middleware('auth:api')->get('profile', [AuthController::class, 'profile']);
// Route::middleware('auth:api')->put('profileupdate', [AuthController::class, 'profileupdate']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/profileupdate', [AuthController::class, 'profileupdate']);

    // Task routes
    Route::post('/tasks', [TaskController::class, 'create']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::post('/tasks/{taskId}/assign', [TaskController::class, 'assign']);
    Route::post('/tasks/{id}/complete', [TaskController::class, 'markComplete']);

    // Category routes
    Route::post('/categories', [CategoryController::class, 'create']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});