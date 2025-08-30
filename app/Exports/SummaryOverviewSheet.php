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
 * Sheet tổng quan
 */
class SummaryOverviewSheet implements FromCollection, WithHeadings, WithStyles
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
        $stats = ShoppingTrip::getMonthlyStats($this->month, $this->year);
        $fundStats = [
            'total_added' => Fund::ofType('add')->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->sum('amount'),
            'total_spent' => Fund::ofType('subtract')->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->sum('amount')
        ];

        return collect([
            ['Chỉ số', 'Giá trị'],
            ['Tháng thống kê', Carbon::create($this->year, $this->month, 1)->format('m/Y')],
            ['Số lần đi chợ', $stats['total_trips']],
            ['Tổng tiền đã chi', number_format($stats['total_amount']) . ' VNĐ'],
            ['Tổng số món đồ', $stats['total_items']],
            ['Trung bình mỗi lần đi chợ', number_format($stats['avg_per_trip']) . ' VNĐ'],
            ['Lần đi chợ đắt nhất', number_format($stats['most_expensive_trip']) . ' VNĐ'],
            ['Lần đi chợ rẻ nhất', number_format($stats['cheapest_trip']) . ' VNĐ'],
            ['', ''],
            ['THÔNG TIN QUỸ', ''],
            ['Tổng tiền nạp vào', number_format($fundStats['total_added']) . ' VNĐ'],
            ['Tổng tiền đã chi', number_format($fundStats['total_spent']) . ' VNĐ'],
            ['Chênh lệch', number_format($fundStats['total_added'] - $fundStats['total_spent']) . ' VNĐ']
        ]);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            10 => ['font' => ['bold' => true]],
        ];
    }
}
