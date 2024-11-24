<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use App\Http\Controllers\Auth;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

Route::post('/login', [Auth\AuthenticatedSessionController::class, 'apiLogin']);
Route::get('/categories', [Api\CategoryController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [Auth\AuthenticatedSessionController::class, 'apiLogout']);
    Route::get('/transactions/summary', [User\TransactionController::class, 'getExpenseSummary'])->name('transactions.summary');
});
