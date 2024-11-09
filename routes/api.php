<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\eventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\Api\AuthController;

    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'register']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/create-event',[eventController::class,'createEvent']);
        Route::get('/get-event',[eventController::class,'getEvent']);
        Route::post('make-book',[BookController::class,'makeBook']);
        Route::post('confirm-booking',[PaymentController::class,'processPayment']);
        Route::get('get-book',[BookController::class,'getBook']);
    });
