<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FundController extends Controller
{
    /**
     * Hiển thị dashboard chính
     */
    public function index()
    {
        $currentBalance = AppSetting::getCurrentFundBalance();
        $recentTransactions = Fund::with('shoppingTrip')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(10)
                                   ->get();

        // Thống kê tháng hiện tại
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthlyStats = [
            'total_added' => Fund::ofType('add')->inMonth($currentMonth, $currentYear)->sum('amount'),
            'total_spent' => Fund::ofType('subtract')->inMonth($currentMonth, $currentYear)->sum('amount'),
            'transactions_count' => Fund::inMonth($currentMonth, $currentYear)->count()
        ];

        return view('funds.index', compact('currentBalance', 'recentTransactions', 'monthlyStats'));
    }

    /**
     * Thêm quỹ
     */
    public function add(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:100000000',
            'description' => 'nullable|string|max:255'
        ], [
            'amount.required' => 'Vui lòng nhập số tiền.',
            'amount.numeric' => 'Số tiền phải là số.',
            'amount.min' => 'Số tiền tối thiểu là 1,000 VNĐ.',
            'amount.max' => 'Số tiền tối đa là 100,000,000 VNĐ.',
            'description.max' => 'Mô tả không được quá 255 ký tự.'
        ]);

        $amount = (int) $request->amount;
        $description = $request->description ?: 'Nạp quỹ ngày ' . now()->format('d/m/Y');

        try {
            Fund::addFund($amount, $description);

            return response()->json([
                'success' => true,
                'message' => 'Nạp quỹ thành công!',
                'new_balance' => AppSetting::getCurrentFundBalance(),
                'formatted_amount' => '+' . number_format($amount) . ' VNĐ'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lịch sử giao dịch quỹ
     */
    public function history(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Validate month và year
        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2020 || $year > now()->year + 1) $year = now()->year;

        $transactions = Fund::inMonth($month, $year)
                            ->with('shoppingTrip')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $monthlyStats = [
            'total_added' => Fund::ofType('add')->inMonth($month, $year)->sum('amount'),
            'total_spent' => Fund::ofType('subtract')->inMonth($month, $year)->sum('amount'),
            'net_change' => Fund::ofType('add')->inMonth($month, $year)->sum('amount') - Fund::ofType('subtract')->inMonth($month, $year)->sum('amount'),
            'transactions_count' => $transactions->count()
        ];

        // Lấy danh sách các tháng có dữ liệu để hiển thị dropdown
        $availableMonths = Fund::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
                               ->groupBy('year', 'month')
                               ->orderBy('year', 'desc')
                               ->orderBy('month', 'desc')
                               ->get()
                               ->map(function ($item) {
                                   return [
                                       'year' => $item->year,
                                       'month' => $item->month,
                                       'label' => Carbon::create($item->year, $item->month)->format('m/Y')
                                   ];
                               });

        return view('funds.history', compact(
            'transactions',
            'monthlyStats',
            'month',
            'year',
            'availableMonths'
        ));
    }

    /**
     * API để lấy số dư hiện tại
     */
    public function getCurrentBalance()
    {
        return response()->json([
            'balance' => AppSetting::getCurrentFundBalance(),
            'formatted_balance' => number_format(AppSetting::getCurrentFundBalance()) . ' VNĐ'
        ]);
    }

    /**
     * API để lấy thống kê nhanh
     */
    public function getQuickStats()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        return response()->json([
            'current_balance' => AppSetting::getCurrentFundBalance(),
            'monthly_added' => Fund::ofType('add')->inMonth($currentMonth, $currentYear)->sum('amount'),
            'monthly_spent' => Fund::ofType('subtract')->inMonth($currentMonth, $currentYear)->sum('amount'),
            'recent_transactions' => Fund::with('shoppingTrip')->orderBy('created_at', 'desc')->limit(5)->get()
        ]);
    }
}
