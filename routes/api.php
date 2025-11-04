<?php

use App\Http\Controllers\FilmsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\ActorsController;
use App\Http\Controllers\DirectorsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/films', [FilmsController::class, 'index']);
Route::get('/series', [SeriesController::class, 'index']);
Route::get('/actors', [ActorsController::class, 'index']);
Route::get('/directors', [DirectorsController::class, 'index']);
Route::post('/users/login', [UsersController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/films', [FilmsController::class, 'store']);
    Route::patch('/films/{id}', [FilmsController::class, 'update']);
    Route::delete('/films/{id}', [FilmsController::class, 'destroy']);

    Route::post('/series', [SeriesController::class, 'store']);
    Route::patch('/series/{id}', [SeriesController::class, 'update']);
    Route::delete('/series/{id}', [SeriesController::class, 'destroy']);

    Route::post('/actors', [ActorsController::class, 'store']);
    Route::patch('/actors/{id}', [ActorsController::class, 'update']);
    Route::delete('/actors/{id}', [ActorsController::class, 'destroy']);
    
    Route::post('/directors', [DirectorsController::class, 'store']);
    Route::patch('/directors/{id}', [DirectorsController::class, 'update']);
    Route::delete('/directors/{id}', [DirectorsController::class, 'destroy']);

    Route::get('/users', [UsersController::class, 'index']);
    
});