<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShoppingTrip;
use App\Models\ShoppingItem;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class ApiShoppingController extends Controller
{
    /**
     * Lấy danh sách lần đi chợ
     */
    public function getTrips(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $limit = $request->get('limit', 10);

        $trips = ShoppingTrip::inMonth($month, $year)
                             ->with(['items:id,shopping_trip_id,item_name,price,quantity,total_price'])
                             ->latest()
                             ->limit($limit)
                             ->get()
                             ->map(function ($trip) {
                                 return [
                                     'id' => $trip->id,
                                     'shopping_date' => $trip->shopping_date->format('Y-m-d'),
                                     'formatted_date' => $trip->shopping_date->format('d/m/Y'),
                                     'total_amount' => $trip->total_amount,
                                     'formatted_total' => number_format($trip->total_amount) . ' VNĐ',
                                     'items_count' => $trip->items_count,
                                     'notes' => $trip->notes,
                                     'items' => $trip->items->map(function ($item) {
                                         return [
                                             'id' => $item->id,
                                             'name' => $item->item_name,
                                             'price' => $item->price,
                                             'quantity' => $item->formatted_quantity,
                                             'total' => $item->total_price,
                                             'formatted_total' => number_format($item->total_price) . ' VNĐ'
                                         ];
                                     }),
                                     'created_at' => $trip->created_at->toISOString()
                                 ];
                             });

        $stats = ShoppingTrip::getMonthlyStats($month, $year);

        return response()->json([
            'success' => true,
            'data' => $trips,
            'stats' => $stats,
            'pagination' => [
                'month' => $month,
                'year' => $year,
                'limit' => $limit,
                'total' => ShoppingTrip::inMonth($month, $year)->count()
            ]
        ]);
    }

    /**
     * Tạo lần đi chợ mới
     */
    public function createTrip(Request $request)
    {
        $request->validate([
            'shopping_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric|min:100',
            'items.*.quantity' => 'nullable|numeric|min:0.1|max:999',
            'items.*.notes' => 'nullable|string|max:255'
        ]);

        try {
            // Tính tổng tiền
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $quantity = $item['quantity'] ?? 1;
                $totalAmount += $item['price'] * $quantity;
            }

            // Kiểm tra quỹ
            $currentBalance = AppSetting::getCurrentFundBalance();
            if ($totalAmount > $currentBalance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quỹ không đủ',
                    'data' => [
                        'required_amount' => $totalAmount,
                        'current_balance' => $currentBalance,
                        'shortage' => $totalAmount - $currentBalance
                    ]
                ], 400);
            }

            // Chuẩn bị dữ liệu items
            $itemsData = [];
            foreach ($request->items as $item) {
                $itemsData[] = [
                    'item_name' => trim($item['item_name']),
                    'price' => (int) $item['price'],
                    'quantity' => $item['quantity'] ?? 1,
                    'notes' => $item['notes'] ?? null
                ];
            }

            // Tạo shopping trip
            $trip = ShoppingTrip::createWithItems([
                'shopping_date' => $request->shopping_date,
                'notes' => $request->notes
            ], $itemsData);

            // Load lại với relationships
            $trip->load('items');

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu lần đi chợ thành công!',
                'data' => [
                    'trip' => [
                        'id' => $trip->id,
                        'shopping_date' => $trip->shopping_date->format('Y-m-d'),
                        'formatted_date' => $trip->formatted_date,
                        'total_amount' => $trip->total_amount,
                        'formatted_total' => $trip->formatted_total,
                        'items_count' => $trip->items_count,
                        'notes' => $trip->notes,
                        'items' => $trip->items->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'name' => $item->item_name,
                                'price' => $item->price,
                                'quantity' => $item->formatted_quantity,
                                'total' => $item->total_price,
                                'notes' => $item->notes
                            ];
                        })
                    ],
                    'new_balance' => AppSetting::getCurrentFundBalance()
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy chi tiết lần đi chợ
     */
    public function getTrip(ShoppingTrip $trip)
    {
        $trip->load(['items', 'fundTransaction']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $trip->id,
                'shopping_date' => $trip->shopping_date->format('Y-m-d'),
                'formatted_date' => $trip->formatted_date,
                'total_amount' => $trip->total_amount,
                'formatted_total' => $trip->formatted_total,
                'items_count' => $trip->items_count,
                'notes' => $trip->notes,
                'items' => $trip->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->item_name,
                        'price' => $item->price,
                        'formatted_price' => number_format($item->price) . ' VNĐ',
                        'quantity' => $item->formatted_quantity,
                        'total' => $item->total_price,
                        'formatted_total' => $item->formatted_total,
                        'notes' => $item->notes
                    ];
                }),
                'fund_transaction' => $trip->fundTransaction ? [
                    'id' => $trip->fundTransaction->id,
                    'amount' => $trip->fundTransaction->amount,
                    'description' => $trip->fundTransaction->description
                ] : null,
                'created_at' => $trip->created_at->toISOString()
            ]
        ]);
    }

    /**
     * Xóa lần đi chợ
     */
    public function deleteTrip(ShoppingTrip $trip)
    {
        try {
            $totalAmount = $trip->total_amount;
            $shoppingDate = $trip->formatted_date;

            $trip->deleteWithRefund();

            return response()->json([
                'success' => true,
                'message' => "Đã xóa lần đi chợ ngày {$shoppingDate} và hoàn lại " . number_format($totalAmount) . " VNĐ",
                'data' => [
                    'refunded_amount' => $totalAmount,
                    'shopping_date' => $shoppingDate,
                    'new_balance' => AppSetting::getCurrentFundBalance()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi khi xóa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gợi ý tên món đồ
     */
    public function getItemSuggestions(Request $request)
    {
        $search = $request->get('search', '');
        $limit = $request->get('limit', 10);

        $suggestions = ShoppingItem::getItemSuggestions($search, $limit);

        return response()->json([
            'success' => true,
            'data' => $suggestions->values(),
            'search' => $search
        ]);
    }

    /**
     * Lấy giá trung bình món đồ
     */
    public function getItemPrice(Request $request)
    {
        $itemName = $request->get('item_name');

        if (!$itemName) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu tên món đồ'
            ], 400);
        }

        $avgPrice = ShoppingItem::where('item_name', 'LIKE', "%{$itemName}%")
                                ->avg('price');

        return response()->json([
            'success' => true,
            'data' => [
                'item_name' => $itemName,
                'average_price' => $avgPrice ? (int) $avgPrice : null,
                'formatted_price' => $avgPrice ? number_format($avgPrice) . ' VNĐ' : null,
                'has_history' => (bool) $avgPrice
            ]
        ]);
    }

    /**
     * Kiểm tra số dư quỹ
     */
    public function checkBalance(Request $request)
    {
        $requestAmount = $request->get('amount', 0);
        $currentBalance = AppSetting::getCurrentFundBalance();

        return response()->json([
            'success' => true,
            'data' => [
                'current_balance' => $currentBalance,
                'formatted_balance' => number_format($currentBalance) . ' VNĐ',
                'request_amount' => $requestAmount,
                'formatted_request' => number_format($requestAmount) . ' VNĐ',
                'is_sufficient' => $requestAmount <= $currentBalance,
                'remaining' => $currentBalance - $requestAmount,
                'formatted_remaining' => number_format(max(0, $currentBalance - $requestAmount)) . ' VNĐ'
            ]
        ]);
    }
}
