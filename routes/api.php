<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiFundController;
use App\Http\Controllers\Api\ApiShoppingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Các API routes cho mobile hoặc AJAX calls
*/

// API Authentication
Route::prefix('auth')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('api.auth');
    Route::get('/check', [ApiAuthController::class, 'check'])->middleware('api.auth');
});

// Protected API Routes
Route::middleware(['api.auth'])->group(function () {

    // Fund APIs
    Route::prefix('funds')->group(function () {
        Route::get('/balance', [ApiFundController::class, 'getBalance']);
        Route::post('/add', [ApiFundController::class, 'addFund']);
        Route::get('/history', [ApiFundController::class, 'getHistory']);
        Route::get('/stats', [ApiFundController::class, 'getStats']);
    });

    // Shopping APIs
    Route::prefix('shopping')->group(function () {
        Route::get('/trips', [ApiShoppingController::class, 'getTrips']);
        Route::post('/trips', [ApiShoppingController::class, 'createTrip']);
        Route::get('/trips/{trip}', [ApiShoppingController::class, 'getTrip']);
        Route::delete('/trips/{trip}', [ApiShoppingController::class, 'deleteTrip']);

        Route::get('/items/suggestions', [ApiShoppingController::class, 'getItemSuggestions']);
        Route::get('/items/price', [ApiShoppingController::class, 'getItemPrice']);

        Route::post('/check-balance', [ApiShoppingController::class, 'checkBalance']);
    });

    // Stats API
    Route::get('/dashboard/stats', function() {
        $currentBalance = \App\Models\AppSetting::getCurrentFundBalance();
        $monthlyStats = [
            'total_added' => \App\Models\Fund::ofType('add')->inMonth(now()->month, now()->year)->sum('amount'),
            'total_spent' => \App\Models\Fund::ofType('subtract')->inMonth(now()->month, now()->year)->sum('amount'),
            'trips_count' => \App\Models\ShoppingTrip::inMonth(now()->month, now()->year)->count()
        ];

        return response()->json([
            'current_balance' => $currentBalance,
            'monthly_stats' => $monthlyStats,
            'timestamp' => now()->toISOString()
        ]);
    });

});
