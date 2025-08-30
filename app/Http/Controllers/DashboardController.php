<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\ShoppingTrip;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard chính
     */
    public function index()
    {
        // Thông tin quỹ hiện tại
        $currentBalance = AppSetting::getCurrentFundBalance();

        // Thống kê tháng hiện tại
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthlyStats = [
            'total_added' => Fund::ofType('add')->inMonth($currentMonth, $currentYear)->sum('amount'),
            'total_spent' => Fund::ofType('subtract')->inMonth($currentMonth, $currentYear)->sum('amount'),
            'trips_count' => ShoppingTrip::inMonth($currentMonth, $currentYear)->count(),
            'items_count' => ShoppingTrip::inMonth($currentMonth, $currentYear)->sum('items_count')
        ];

        // 5 lần giao dịch gần nhất
        $recentTransactions = Fund::with('shoppingTrip')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(5)
                                   ->get();

        // 3 lần đi chợ gần nhất
        $recentTrips = ShoppingTrip::with(['items' => function($query) {
                                       $query->limit(3);
                                   }])
                                   ->orderBy('shopping_date', 'desc')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(3)
                                   ->get();

        // Tên người dùng
        $userNames = AppSetting::getUserNames();

        // Kiểm tra cảnh báo quỹ thấp
        $lowFundWarning = $currentBalance < 100000; // Cảnh báo khi quỹ dưới 100k

        return view('dashboard.index', compact(
            'currentBalance',
            'monthlyStats',
            'recentTransactions',
            'recentTrips',
            'userNames',
            'lowFundWarning'
        ));
    }
}
