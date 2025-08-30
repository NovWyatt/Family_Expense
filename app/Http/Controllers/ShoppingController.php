<?php

namespace App\Http\Controllers;

use App\Models\ShoppingTrip;
use App\Models\ShoppingItem;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShoppingController extends Controller
{
    /**
     * Danh sách các lần đi chợ
     */
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $trips = ShoppingTrip::inMonth($month, $year)
                             ->with(['items'])
                             ->latest()
                             ->paginate(20);

        $monthlyStats = ShoppingTrip::getMonthlyStats($month, $year);

        // Lấy danh sách tháng có dữ liệu
        $availableMonths = ShoppingTrip::selectRaw('YEAR(shopping_date) as year, MONTH(shopping_date) as month')
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

        return view('shopping.index', compact('trips', 'monthlyStats', 'month', 'year', 'availableMonths'));
    }

    /**
     * Hiển thị form tạo lần đi chợ mới
     */
    public function create()
    {
        $currentBalance = AppSetting::getCurrentFundBalance();
        $itemSuggestions = ShoppingItem::getItemSuggestions('', 20);

        return view('shopping.create', compact('currentBalance', 'itemSuggestions'));
    }

    /**
     * Lưu lần đi chợ mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'shopping_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric|min:100',
            'items.*.quantity' => 'nullable|numeric|min:0.1|max:999',
            'items.*.notes' => 'nullable|string|max:255'
        ], [
            'shopping_date.required' => 'Vui lòng chọn ngày đi chợ.',
            'shopping_date.before_or_equal' => 'Ngày đi chợ không được lớn hơn hôm nay.',
            'items.required' => 'Vui lòng thêm ít nhất 1 món đồ.',
            'items.*.item_name.required' => 'Tên món đồ không được để trống.',
            'items.*.price.required' => 'Giá tiền không được để trống.',
            'items.*.price.min' => 'Giá tiền tối thiểu là 100 VNĐ.',
            'items.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
        ]);

        // Tính tổng tiền
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $quantity = $item['quantity'] ?? 1;
            $totalAmount += $item['price'] * $quantity;
        }

        // Kiểm tra quỹ đủ không
        $currentBalance = AppSetting::getCurrentFundBalance();
        if ($totalAmount > $currentBalance) {
            return back()->withErrors([
                'total_amount' => 'Tổng tiền (' . number_format($totalAmount) . ' VNĐ) vượt quá số dư quỹ hiện tại (' . number_format($currentBalance) . ' VNĐ).'
            ])->withInput();
        }

        try {
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

            return redirect()->route('shopping.show', $trip)
                           ->with('success', 'Đã lưu lần đi chợ thành công! Tổng tiền: ' . number_format($trip->total_amount) . ' VNĐ');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Chi tiết lần đi chợ
     */
    public function show(ShoppingTrip $trip)
    {
        $trip->load('items', 'fundTransaction');
        return view('shopping.show', compact('trip'));
    }

    /**
     * Xóa lần đi chợ và hoàn lại quỹ
     */
    public function destroy(ShoppingTrip $trip)
    {
        try {
            $totalAmount = $trip->total_amount;
            $shoppingDate = $trip->formatted_date;

            $trip->deleteWithRefund();

            return redirect()->route('shopping.index')
                           ->with('success', "Đã xóa lần đi chợ ngày {$shoppingDate} và hoàn lại {$totalAmount} VNĐ vào quỹ.");
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Có lỗi khi xóa: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * API: Gợi ý tên món đồ (autocomplete)
     */
    public function getItemSuggestions(Request $request)
    {
        $search = $request->get('search', '');
        $suggestions = ShoppingItem::getItemSuggestions($search, 10);

        return response()->json($suggestions);
    }

    /**
     * API: Lấy giá trung bình của món đồ
     */
    public function getItemAveragePrice(Request $request)
    {
        $itemName = $request->get('item_name');

        if (!$itemName) {
            return response()->json(['price' => null]);
        }

        $avgPrice = ShoppingItem::where('item_name', 'LIKE', "%{$itemName}%")
                                ->avg('price');

        return response()->json([
            'price' => $avgPrice ? (int) $avgPrice : null,
            'formatted_price' => $avgPrice ? number_format($avgPrice) : null
        ]);
    }

    /**
     * API: Kiểm tra số dư quỹ
     */
    public function checkFundBalance(Request $request)
    {
        $requestAmount = $request->get('amount', 0);
        $currentBalance = AppSetting::getCurrentFundBalance();

        return response()->json([
            'current_balance' => $currentBalance,
            'request_amount' => $requestAmount,
            'is_sufficient' => $requestAmount <= $currentBalance,
            'remaining' => $currentBalance - $requestAmount
        ]);
    }
}
