<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Auth\AuthenticatedSessionController::class, 'apiLogin']);
Route::get('/categories', [Api\CategoryController::class, 'index']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
