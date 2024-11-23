<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;


Route::get('/categories', [Api\CategoryController::class, 'index']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
