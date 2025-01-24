<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});

// Protected routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Account routes
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index'); // Get all accounts
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store'); // Create a new account

    // Transaction routes
    Route::post('/transactions/deposit', [TransactionController::class, 'deposit'])->name('transactions.deposit'); // Deposit
    Route::post('/transactions/withdraw', [TransactionController::class, 'withdraw'])->name('transactions.withdraw'); // Withdraw
    Route::post('/transactions/transfer', [TransactionController::class, 'transfer'])->name('transactions.transfer'); // Transfer
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index'); // Get all transactions

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index'); // Get all notifications
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read'); // Mark notification as read
});