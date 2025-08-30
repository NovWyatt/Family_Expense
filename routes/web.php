<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes không cần authentication (chỉ có login)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Routes cần authentication (tất cả routes khác)
Route::middleware(['check.app.password'])->group(function () {

    // Dashboard - Trang chủ
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');

    // Quản lý quỹ
    Route::prefix('funds')->name('funds.')->group(function () {
        Route::get('/', [FundController::class, 'index'])->name('index');
        Route::post('/add', [FundController::class, 'add'])->name('add');
        Route::get('/history', [FundController::class, 'history'])->name('history');

        // API routes cho quỹ
        Route::get('/api/balance', [FundController::class, 'getCurrentBalance'])->name('api.balance');
        Route::get('/api/stats', [FundController::class, 'getQuickStats'])->name('api.stats');
    });

    // Đi chợ
    Route::prefix('shopping')->name('shopping.')->group(function () {
        Route::get('/', [ShoppingController::class, 'index'])->name('index');
        Route::get('/create', [ShoppingController::class, 'create'])->name('create');
        Route::post('/store', [ShoppingController::class, 'store'])->name('store');
        Route::get('/{trip}', [ShoppingController::class, 'show'])->name('show');
        Route::delete('/{trip}', [ShoppingController::class, 'destroy'])->name('destroy');

        // API routes cho shopping
        Route::get('/api/item-suggestions', [ShoppingController::class, 'getItemSuggestions'])->name('api.item.suggestions');
        Route::get('/api/item-price', [ShoppingController::class, 'getItemAveragePrice'])->name('api.item.price');
        Route::post('/api/check-balance', [ShoppingController::class, 'checkFundBalance'])->name('api.check.balance');
    });

    // Xuất Excel
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/', [ExportController::class, 'index'])->name('index');
        Route::get('/monthly/{month}/{year}', [ExportController::class, 'monthly'])->name('monthly');
        Route::get('/summary/{month}/{year}', [ExportController::class, 'summary'])->name('summary');
    });

    // Settings routes (nếu cần thêm sau)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', function() {
            return view('settings.index');
        })->name('index');
    });

});
