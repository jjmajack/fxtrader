<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TradePlanController;

// Public routes
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('welcome');
});


// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
        // Trade Plans
        Route::resource('trade-plans', TradePlanController::class);
        Route::patch('/trade-plans/{tradePlan}/status', [TradePlanController::class, 'updateStatus'])->name('trade-plans.update-status');
        Route::patch('/trade-plans/{tradePlan}/result', [TradePlanController::class, 'updateResult'])->name('trade-plans.update-result');

        // Trading Pairs Management
        Route::resource('trading-pairs', \App\Http\Controllers\TradingPairController::class);
        Route::patch('/trading-pairs/{tradingPair}/toggle-status', [\App\Http\Controllers\TradingPairController::class, 'toggleStatus'])->name('trading-pairs.toggle-status');
});
