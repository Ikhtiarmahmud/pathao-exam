<?php

use Illuminate\Support\Facades\Route
;

Route::get('/login', function () {
    return response()->json(['error' => 'You are not authorized'], 401);
})->name('login');