<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [UserController::class, 'register']);

Route::post('/getToken', [UserController::class, 'getToken']);

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::delete('/dropToken', [UserController::class, 'dropToken']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'book'], function () {
        Route::post('/create', [BookController::class, 'create']);
        Route::get('/show', [BookController::class, 'show']);
        Route::delete('/delete/{id}', [BookController::class, 'delete']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('/create', [OrderController::class, 'create']);
        Route::post('/compite', [OrderController::class, 'compite']);
    });
});
