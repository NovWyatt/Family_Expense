<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ShoppingTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_date',
        'total_amount',
        'notes',
        'items_count'
    ];

    protected $casts = [
        'shopping_date' => 'date',
        'total_amount' => 'integer', // Vì migration dùng decimal(15,0)
    ];

    /**
     * Relationship với ShoppingItem
     */
    public function items()
    {
        return $this->hasMany(ShoppingItem::class);
    }

    /**
     * Relationship với Fund
     */
    public function fundTransaction()
    {
        return $this->hasOne(Fund::class);
    }

    /**
     * Scope để lọc theo tháng
     */
    public function scopeInMonth($query, $month, $year)
    {
        return $query->whereMonth('shopping_date', $month)
                     ->whereYear('shopping_date', $year);
    }

    /**
     * Scope để sắp xếp theo ngày mới nhất
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('shopping_date', 'desc')
                     ->orderBy('created_at', 'desc');
    }

    /**
     * Tự động tính tổng tiền và số lượng items khi có thay đổi
     */
    public function recalculateTotal()
    {
        $this->total_amount = $this->items()->sum('total_price');
        $this->items_count = $this->items()->count();
        $this->save();

        return $this;
    }

    /**
     * Tạo lần đi chợ mới và trừ quỹ
     */
    public static function createWithItems($data, $items)
    {
        // Tạo shopping trip
        $trip = self::create([
            'shopping_date' => $data['shopping_date'],
            'notes' => $data['notes'] ?? null
        ]);

        // Thêm các items
        foreach ($items as $itemData) {
            $trip->items()->create([
                'item_name' => $itemData['item_name'],
                'price' => $itemData['price'],
                'quantity' => $itemData['quantity'] ?? 1,
                'total_price' => $itemData['price'] * ($itemData['quantity'] ?? 1),
                'notes' => $itemData['notes'] ?? null
            ]);
        }

        // Tính lại tổng
        $trip->recalculateTotal();

        // Trừ quỹ
        Fund::subtractFund(
            $trip->total_amount,
            'Đi chợ ngày ' . $trip->shopping_date->format('d/m/Y'),
            $trip->id
        );

        return $trip;
    }

    /**
     * Xóa lần đi chợ và hoàn lại quỹ
     */
    public function deleteWithRefund()
    {
        // Hoàn lại quỹ bằng cách thêm lại số tiền đã trừ
        Fund::addFund(
            $this->total_amount,
            'Hoàn tiền từ lần đi chợ ngày ' . $this->shopping_date->format('d/m/Y')
        );

        // Xóa fund transaction liên quan
        if ($this->fundTransaction) {
            $this->fundTransaction->delete();
        }

        // Xóa shopping trip (items sẽ tự động xóa do cascade)
        $this->delete();
    }

    /**
     * Lấy danh sách đi chợ theo tháng
     */
    public static function getMonthlyTrips($month, $year)
    {
        return self::inMonth($month, $year)
                   ->with(['items'])
                   ->latest()
                   ->get();
    }

    /**
     * Thống kê theo tháng
     */
    public static function getMonthlyStats($month, $year)
    {
        $trips = self::inMonth($month, $year)->with('items')->get();

        return [
            'total_trips' => $trips->count(),
            'total_amount' => $trips->sum('total_amount'),
            'total_items' => $trips->sum('items_count'),
            'avg_per_trip' => $trips->count() > 0 ? $trips->avg('total_amount') : 0,
            'most_expensive_trip' => $trips->max('total_amount'),
            'cheapest_trip' => $trips->min('total_amount')
        ];
    }

    /**
     * Accessor để format ngày đi chợ
     */
    public function getFormattedDateAttribute()
    {
        return $this->shopping_date->format('d/m/Y');
    }

    /**
     * Accessor để format tổng tiền
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount) . ' VNĐ';
    }
}
