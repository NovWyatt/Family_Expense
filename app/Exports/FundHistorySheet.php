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
 * Sheet lịch sử quỹ
 */
class FundHistorySheet implements FromCollection, WithHeadings
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
        return Fund::whereMonth('created_at', $this->month)
                   ->whereYear('created_at', $this->year)
                   ->with('shoppingTrip')
                   ->orderBy('created_at', 'desc')
                   ->get()
                   ->map(function ($fund) {
                       return [
                           'Ngày' => $fund->created_at->format('d/m/Y H:i'),
                           'Loại' => $fund->type === 'add' ? 'Nạp tiền' : 'Chi tiêu',
                           'Số tiền' => $fund->type === 'add' ? $fund->amount : -$fund->amount,
                           'Mô tả' => $fund->description,
                           'Liên quan đi chợ' => $fund->shoppingTrip ? $fund->shoppingTrip->shopping_date->format('d/m/Y') : ''
                       ];
                   });
    }

    public function headings(): array
    {
        return ['Ngày giao dịch', 'Loại', 'Số tiền (VNĐ)', 'Mô tả', 'Ngày đi chợ'];
    }
}
