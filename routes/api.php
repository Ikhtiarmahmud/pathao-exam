<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return "<h1>Welcome to Pathao</h1>";
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [App\Http\Controllers\RegistrationController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\RegistrationController::class, 'logout'])->middleware('auth:sanctum');
});


Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

   Route::get('orders', [\App\Http\Controllers\OrderController::class, 'getOrders']);
   Route::post('orders', [\App\Http\Controllers\OrderController::class, 'store']);
});