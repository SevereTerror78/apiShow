<?php

use App\Http\Controllers\FilmsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/films', [FilmsController::class, 'index']);
Route::post('/users/login', [UsersController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/films', [FilmsController::class, 'store']);
    Route::patch('/films/{id}', [FilmsController::class, 'update']);
    Route::delete('/films/{id}', [FilmsController::class, 'destroy']);
    
    Route::get('/users', [UsersController::class, 'index']);
    
});