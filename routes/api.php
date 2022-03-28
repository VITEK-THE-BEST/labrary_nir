<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [UserController::class, 'register']);

Route::post('/getToken', [UserController::class, 'getToken']);

Route::group(['prefix' => 'book'], function () {
    Route::get('/show', [BookController::class, 'show']);
});

Route::group(['prefix' => 'order'], function () {
    Route::get('/getPrice/{book}', [OrderController::class, 'getPrice']);
});

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::delete('/dropToken', [UserController::class, 'dropToken']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'book'], function () {
        Route::post('/create', [BookController::class, 'create']);
        Route::delete('/delete/{id}', [BookController::class, 'delete']);
    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('/create/{book}', [OrderController::class, 'create']);
        Route::patch('/complete/{book}', [OrderController::class, 'complete']);
    });
});
