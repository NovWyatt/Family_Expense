<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'type',
        'description',
        'shopping_trip_id'
    ];

    protected $casts = [
        'amount' => 'integer', // Vì migration dùng decimal(15,0)
    ];

    /**
     * Relationship với ShoppingTrip
     */
    public function shoppingTrip()
    {
        return $this->belongsTo(ShoppingTrip::class);
    }

    /**
     * Scope để lọc theo loại giao dịch
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope để lọc theo tháng
     */
    public function scopeInMonth($query, $month, $year)
    {
        return $query->whereMonth('created_at', $month)
                     ->whereYear('created_at', $year);
    }

    /**
     * Tính tổng quỹ hiện tại từ database
     */
    public static function calculateCurrentBalance()
    {
        $totalAdded = self::where('type', 'add')->sum('amount');
        $totalSubtracted = self::where('type', 'subtract')->sum('amount');

        return $totalAdded - $totalSubtracted;
    }

    /**
     * Thêm quỹ
     */
    public static function addFund($amount, $description = 'Nạp quỹ')
    {
        $fund = self::create([
            'amount' => $amount,
            'type' => 'add',
            'description' => $description
        ]);

        // Cập nhật số dư trong app_settings
        $newBalance = self::calculateCurrentBalance();
        AppSetting::updateFundBalance($newBalance);

        return $fund;
    }

    /**
     * Trừ quỹ (khi đi chợ)
     */
    public static function subtractFund($amount, $description = 'Đi chợ', $shoppingTripId = null)
    {
        $fund = self::create([
            'amount' => $amount,
            'type' => 'subtract',
            'description' => $description,
            'shopping_trip_id' => $shoppingTripId
        ]);

        // Cập nhật số dư trong app_settings
        $newBalance = self::calculateCurrentBalance();
        AppSetting::updateFundBalance($newBalance);

        return $fund;
    }

    /**
     * Lấy lịch sử giao dịch theo tháng
     */
    public static function getMonthlyHistory($month, $year)
    {
        return self::inMonth($month, $year)
                   ->with('shoppingTrip')
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Accessor để hiển thị số tiền có dấu + hoặc -
     */
    public function getFormattedAmountAttribute()
    {
        $sign = $this->type === 'add' ? '+' : '-';
        return $sign . number_format($this->amount) . ' VNĐ';
    }
}
