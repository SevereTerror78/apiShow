<?php

use App\Http\Controllers\FilmsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/films', [FilmsController::class, 'index']);
Route::post('/films', [FilmsController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/films/{id}', [FilmsController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/films/{id}', [FilmsController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');
Route::post('/users/login', [UsersController::class, 'login']);

