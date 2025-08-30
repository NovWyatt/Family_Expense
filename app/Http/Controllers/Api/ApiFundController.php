<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class ApiFundController extends Controller
{
    /**
     * Lấy số dư hiện tại
     */
    public function getBalance()
    {
        return response()->json([
            'success' => true,
            'balance' => AppSetting::getCurrentFundBalance(),
            'formatted_balance' => number_format(AppSetting::getCurrentFundBalance()) . ' VNĐ',
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Thêm quỹ
     */
    public function addFund(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:100000000',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $amount = (int) $request->amount;
            $description = $request->description ?: 'Nạp quỹ từ API - ' . now()->format('d/m/Y H:i');

            $fund = Fund::addFund($amount, $description);

            return response()->json([
                'success' => true,
                'message' => 'Nạp quỹ thành công!',
                'data' => [
                    'fund_id' => $fund->id,
                    'amount' => $amount,
                    'formatted_amount' => '+' . number_format($amount) . ' VNĐ',
                    'description' => $fund->description,
                    'new_balance' => AppSetting::getCurrentFundBalance(),
                    'formatted_balance' => number_format(AppSetting::getCurrentFundBalance()) . ' VNĐ',
                    'created_at' => $fund->created_at->toISOString()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy lịch sử giao dịch
     */
    public function getHistory(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $limit = $request->get('limit', 20);

        $transactions = Fund::inMonth($month, $year)
                            ->with('shoppingTrip:id,shopping_date,total_amount')
                            ->orderBy('created_at', 'desc')
                            ->limit($limit)
                            ->get()
                            ->map(function ($fund) {
                                return [
                                    'id' => $fund->id,
                                    'type' => $fund->type,
                                    'type_label' => $fund->type === 'add' ? 'Nạp tiền' : 'Chi tiêu',
                                    'amount' => $fund->amount,
                                    'formatted_amount' => $fund->formatted_amount,
                                    'description' => $fund->description,
                                    'shopping_trip' => $fund->shoppingTrip ? [
                                        'id' => $fund->shoppingTrip->id,
                                        'date' => $fund->shoppingTrip->shopping_date->format('d/m/Y'),
                                        'total' => $fund->shoppingTrip->total_amount
                                    ] : null,
                                    'created_at' => $fund->created_at->toISOString(),
                                    'formatted_date' => $fund->created_at->format('d/m/Y H:i')
                                ];
                            });

        return response()->json([
            'success' => true,
            'data' => $transactions,
            'pagination' => [
                'month' => $month,
                'year' => $year,
                'limit' => $limit,
                'total' => Fund::inMonth($month, $year)->count()
            ]
        ]);
    }

    /**
     * Lấy thống kê
     */
    public function getStats(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $monthlyStats = [
            'total_added' => Fund::ofType('add')->inMonth($month, $year)->sum('amount'),
            'total_spent' => Fund::ofType('subtract')->inMonth($month, $year)->sum('amount'),
            'net_change' => Fund::ofType('add')->inMonth($month, $year)->sum('amount') - Fund::ofType('subtract')->inMonth($month, $year)->sum('amount'),
            'transactions_count' => Fund::inMonth($month, $year)->count()
        ];

        // Thống kê so với tháng trước
        $prevMonth = $month == 1 ? 12 : $month - 1;
        $prevYear = $month == 1 ? $year - 1 : $year;

        $prevMonthStats = [
            'total_added' => Fund::ofType('add')->inMonth($prevMonth, $prevYear)->sum('amount'),
            'total_spent' => Fund::ofType('subtract')->inMonth($prevMonth, $prevYear)->sum('amount')
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'current_balance' => AppSetting::getCurrentFundBalance(),
                'monthly' => $monthlyStats,
                'comparison' => [
                    'added_change' => $prevMonthStats['total_added'] > 0 ?
                        round((($monthlyStats['total_added'] - $prevMonthStats['total_added']) / $prevMonthStats['total_added']) * 100, 1) :
                        ($monthlyStats['total_added'] > 0 ? 100 : 0),
                    'spent_change' => $prevMonthStats['total_spent'] > 0 ?
                        round((($monthlyStats['total_spent'] - $prevMonthStats['total_spent']) / $prevMonthStats['total_spent']) * 100, 1) :
                        ($monthlyStats['total_spent'] > 0 ? 100 : 0)
                ],
                'period' => [
                    'month' => $month,
                    'year' => $year,
                    'month_name' => now()->month($month)->format('F'),
                    'formatted' => sprintf('%02d/%04d', $month, $year)
                ]
            ]
        ]);
    }
}
