<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', Admin\CategoryController::class);
});
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('accounts', User\AccountController::class);
    Route::resource('categories', User\CategoryController::class)->only('index');
    Route::resource('transactions', User\TransactionController::class)->only(['index', 'store']);
    Route::get('/transactions/report', [User\TransactionController::class, 'generateReport'])->name('transactions.report');
    Route::get('/transactions/summary', [User\TransactionController::class, 'expenseSummary'])->name('transactions.summary');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
