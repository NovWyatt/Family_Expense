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
 * Export class cho chi tiết tháng
 */
class MonthlyDetailExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
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
        $trips = ShoppingTrip::whereMonth('shopping_date', $this->month)
                             ->whereYear('shopping_date', $this->year)
                             ->with(['items'])
                             ->orderBy('shopping_date', 'desc')
                             ->get();

        $data = collect();

        foreach ($trips as $trip) {
            foreach ($trip->items as $item) {
                $data->push([
                    'Ngày' => $trip->shopping_date->format('d/m/Y'),
                    'Tên món đồ' => $item->item_name,
                    'Giá đơn vị' => $item->price,
                    'Số lượng' => $item->formatted_quantity,
                    'Thành tiền' => $item->total_price,
                    'Ghi chú món đồ' => $item->notes,
                    'Tổng tiền lần đi chợ' => $trip->total_amount,
                    'Ghi chú lần đi chợ' => $trip->notes
                ]);
            }
        }

        // Thêm dòng tổng kết
        if ($data->count() > 0) {
            $data->push([
                'Ngày' => '',
                'Tên món đồ' => '',
                'Giá đơn vị' => '',
                'Số lượng' => '',
                'Thành tiền' => '',
                'Ghi chú món đồ' => '',
                'Tổng tiền lần đi chợ' => '',
                'Ghi chú lần đi chợ' => ''
            ]);

            $data->push([
                'Ngày' => 'TỔNG KẾT',
                'Tên món đồ' => '',
                'Giá đơn vị' => '',
                'Số lượng' => $trips->sum('items_count') . ' món',
                'Thành tiền' => $trips->sum('total_amount'),
                'Ghi chú món đồ' => '',
                'Tổng tiền lần đi chợ' => '',
                'Ghi chú lần đi chợ' => Carbon::create($this->year, $this->month, 1)->format('m/Y')
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Ngày đi chợ',
            'Tên món đồ',
            'Giá đơn vị (VNĐ)',
            'Số lượng',
            'Thành tiền (VNĐ)',
            'Ghi chú món đồ',
            'Tổng tiền lần đi chợ (VNĐ)',
            'Ghi chú lần đi chợ'
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A:H' => ['alignment' => ['vertical' => 'center']],
        ];
    }
}


