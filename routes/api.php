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
    Route::post('/create', [BookController::class, 'create']);

});

Route::group(['prefix' => 'order'], function () {
    Route::post('/getPrice/{book}', [OrderController::class, 'getPrice']);
});

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/me', [UserController::class, 'me']);
        Route::delete('/dropToken', [UserController::class, 'dropToken']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
    });


    Route::group(['prefix' => 'order'], function () {
        Route::post('/create/{book}', [OrderController::class, 'create']);
        Route::get('/complete/{book}', [OrderController::class, 'complete']);
        Route::get('/showCompleteOrder', [OrderController::class, 'showCompleteOrder']);
        Route::get('/showNotCompleteOrder', [OrderController::class, 'showNotCompleteOrder']);
        Route::get('/getCompletePrice/{book}', [OrderController::class, 'getCompletePrice']);
    });
});

Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/showAllUsers', [UserController::class, 'showAllUsers']);
            Route::get('/me', [UserController::class, 'me']);
            Route::delete('/dropToken', [UserController::class, 'dropToken']);
        });

        Route::group(['prefix' => 'book'], function () {
            Route::post('/create', [BookController::class, 'create']);
            Route::delete('/delete/{id}', [BookController::class, 'delete']);
        });

        Route::group(['prefix' => 'order'], function () {
            Route::post('/create/{book}', [OrderController::class, 'createAdmin']);
            Route::get('/completeAdmin/{book}/{user}', [OrderController::class, 'completeAdmin']);
            Route::get('/showAllCompleteOrder', [OrderController::class, 'showAllCompleteOrder']);
            Route::get('/showAllNotCompleteOrder', [OrderController::class, 'showAllNotCompleteOrder']);
        });
    });
});
