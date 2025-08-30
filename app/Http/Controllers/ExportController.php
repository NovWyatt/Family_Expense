<?php

namespace App\Http\Controllers;

use App\Models\ShoppingTrip;
use App\Models\ShoppingItem;
use App\Models\Fund;
use App\Models\AppSetting;
use App\Exports\MonthlyDetailExport;
use App\Exports\MonthlySummaryExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Trang xuất Excel
     */
    public function index()
    {
        // Lấy danh sách các tháng có dữ liệu
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

        return view('export.index', compact('availableMonths'));
    }

    /**
     * Xuất Excel chi tiết theo tháng
     */
    public function monthly($month, $year)
    {
        // Validate input
        if ($month < 1 || $month > 12 || $year < 2020 || $year > now()->year + 1) {
            return back()->withErrors(['error' => 'Tháng hoặc năm không hợp lệ.']);
        }

        $monthName = Carbon::create($year, $month, 1)->format('m-Y');
        $fileName = "Chi_tiet_{$monthName}.xlsx";

        return Excel::download(new MonthlyDetailExport($month, $year), $fileName);
    }

    /**
     * Xuất Excel thống kê tháng
     */
    public function summary($month, $year)
    {
        // Validate input
        if ($month < 1 || $month > 12 || $year < 2020 || $year > now()->year + 1) {
            return back()->withErrors(['error' => 'Tháng hoặc năm không hợp lệ.']);
        }

        $monthName = Carbon::create($year, $month, 1)->format('m-Y');
        $fileName = "Thong_ke_{$monthName}.xlsx";

        return Excel::download(new MonthlySummaryExport($month, $year), $fileName);
    }
}
