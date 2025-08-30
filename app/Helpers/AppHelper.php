<?php

namespace App\Helpers;

use App\Models\AppSetting;
use Carbon\Carbon;

class AppHelper
{
    /**
     * Format tiền tệ VNĐ
     */
    public static function formatCurrency($amount)
    {
        return number_format($amount) . ' VNĐ';
    }

    /**
     * Format ngày tháng kiểu Việt Nam
     */
    public static function formatDate($date, $format = 'd/m/Y')
    {
        return Carbon::parse($date)->format($format);
    }

    /**
     * Format datetime kiểu Việt Nam
     */
    public static function formatDateTime($date, $format = 'd/m/Y H:i')
    {
        return Carbon::parse($date)->format($format);
    }

    /**
     * Lấy tên tháng tiếng Việt
     */
    public static function getVietnameseMonth($month)
    {
        $months = [
            1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3',
            4 => 'Tháng 4', 5 => 'Tháng 5', 6 => 'Tháng 6',
            7 => 'Tháng 7', 8 => 'Tháng 8', 9 => 'Tháng 9',
            10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12'
        ];

        return $months[$month] ?? "Tháng {$month}";
    }

    /**
     * Kiểm tra có đủ quỹ không
     */
    public static function hasSufficientFund($requiredAmount)
    {
        $currentBalance = AppSetting::getCurrentFundBalance();
        return $currentBalance >= $requiredAmount;
    }

    /**
     * Tính phần trăm thay đổi
     */
    public static function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }

        return round((($newValue - $oldValue) / $oldValue) * 100, 1);
    }

    /**
     * Lấy tên file Excel an toàn
     */
    public static function getSafeFileName($filename)
    {
        // Loại bỏ ký tự đặc biệt, chỉ giữ lại chữ cái, số, dấu gạch ngang và underscore
        $filename = preg_replace('/[^\w\-_\.]/', '_', $filename);
        return $filename;
    }

    /**
     * Tạo breadcrumb cho navigation
     */
    public static function getBreadcrumb($currentRoute)
    {
        $breadcrumbs = [
            'dashboard' => [
                ['name' => 'Trang chủ', 'url' => route('dashboard')]
            ],
            'funds.index' => [
                ['name' => 'Trang chủ', 'url' => route('dashboard')],
                ['name' => 'Quản lý quỹ', 'url' => route('funds.index')]
            ],
            'funds.history' => [
                ['name' => 'Trang chủ', 'url' => route('dashboard')],
                ['name' => 'Quản lý quỹ', 'url' => route('funds.index')],
                ['name' => 'Lịch sử', 'url' => route('funds.history')]
            ],
            'shopping.index' => [
                ['name' => 'Trang chủ', 'url' => route('dashboard')],
                ['name' => 'Đi chợ', 'url' => route('shopping.index')]
            ],
            'shopping.create' => [
                ['name' => 'Trang chủ', 'url' => route('dashboard')],
                ['name' => 'Đi chợ', 'url' => route('shopping.index')],
                ['name' => 'Thêm mới', 'url' => route('shopping.create')]
            ],
            'export.index' => [
                ['name' => 'Trang chủ', 'url' => route('dashboard')],
                ['name' => 'Xuất Excel', 'url' => route('export.index')]
            ]
        ];

        return $breadcrumbs[$currentRoute] ?? [
            ['name' => 'Trang chủ', 'url' => route('dashboard')]
        ];
    }

    /**
     * Validate số tiền VNĐ
     */
    public static function validateVietnamCurrency($amount)
    {
        // Loại bỏ dấu phẩy và khoảng trắng
        $amount = str_replace([',', ' ', '.'], '', $amount);

        // Kiểm tra chỉ chứa số
        if (!is_numeric($amount)) {
            return false;
        }

        $amount = (int) $amount;

        // Kiểm tra range hợp lý cho gia đình Việt Nam
        return $amount >= 100 && $amount <= 100000000; // 100 VNĐ -> 100M VNĐ
    }

    /**
     * Lấy màu sắc cho status
     */
    public static function getStatusColor($type)
    {
        return match($type) {
            'add', 'income', 'success' => 'success',
            'subtract', 'expense', 'warning' => 'warning',
            'error', 'danger' => 'danger',
            'info', 'primary' => 'primary',
            default => 'secondary'
        };
    }

    /**
     * Tạo notification message
     */
    public static function createNotification($type, $title, $message)
    {
        return [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'timestamp' => now()->toISOString()
        ];
    }
}
