<?php

use App\Http\Controllers\Api\TaskController;

use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskController::class, 'index']);

Route::post('/tasks', [TaskController::class, 'store']);

Route::get('/task/complete', [TaskController::class, 'completed']);

Route::put('/task/{task}', [TaskController::class, 'update']);

Route::put('/task/{task}/complete', [TaskController::class, 'complete']);

Route::delete('/task/{task}', [TaskController::class, 'destroy']);