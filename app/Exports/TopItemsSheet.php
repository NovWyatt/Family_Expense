<?php

namespace App\Exports;

use App\Models\ShoppingTrip;
use App\Models\ShoppingItem;
use App\Models\Fund;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


/**
 * Sheet top món đồ
 */
class TopItemsSheet implements FromCollection, WithHeadings
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return ShoppingItem::whereHas('shoppingTrip', function ($q) {
                                $q->whereMonth('shopping_date', $this->month)
                                  ->whereYear('shopping_date', $this->year);
                            })
                          ->selectRaw('item_name, COUNT(*) as frequency, SUM(total_price) as total_spent, AVG(price) as avg_price')
                          ->groupBy('item_name')
                          ->orderByDesc('frequency')
                          ->orderByDesc('total_spent')
                          ->limit(20)
                          ->get()
                          ->map(function ($item, $index) {
                              return [
                                  'STT' => $index + 1,
                                  'Tên món đồ' => $item->item_name,
                                  'Số lần mua' => $item->frequency,
                                  'Tổng tiền' => $item->total_spent,
                                  'Giá trung bình' => round($item->avg_price)
                              ];
                          });
    }

    public function headings(): array
    {
        return ['STT', 'Tên món đồ', 'Số lần mua', 'Tổng tiền (VNĐ)', 'Giá TB (VNĐ)'];
    }
}
