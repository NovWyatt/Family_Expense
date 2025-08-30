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
 * Export class cho thống kê tháng
 */
class MonthlySummaryExport implements WithMultipleSheets
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function sheets(): array
    {
        return [
            'Tổng quan' => new SummaryOverviewSheet($this->month, $this->year),
            'Top món đồ' => new TopItemsSheet($this->month, $this->year),
            'Lịch sử quỹ' => new FundHistorySheet($this->month, $this->year),
        ];
    }
}
