<?php

use App\Http\Controllers\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('signup', [AdminAuthController::class, 'adminSignup']);
Route::post('login', [AdminAuthController::class, 'adminLogin']);