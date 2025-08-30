<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shopping_trip_id',
        'item_name',
        'price',
        'quantity',
        'total_price',
        'notes'
    ];

    protected $casts = [
        'price' => 'integer', // Vì migration dùng decimal(15,0)
        'quantity' => 'decimal:1', // Vì migration dùng decimal(8,1)
        'total_price' => 'integer', // Vì migration dùng decimal(15,0)
    ];

    /**
     * Relationship với ShoppingTrip
     */
    public function shoppingTrip()
    {
        return $this->belongsTo(ShoppingTrip::class);
    }

    /**
     * Boot method để tự động tính total_price
     */
    protected static function boot()
    {
        parent::boot();

        // Khi tạo mới
        static::creating(function ($item) {
            $item->total_price = $item->price * $item->quantity;
        });

        // Khi cập nhật
        static::updating(function ($item) {
            $item->total_price = $item->price * $item->quantity;
        });

        // Sau khi tạo, cập nhật, xóa -> cập nhật lại tổng của shopping trip
        static::saved(function ($item) {
            $item->shoppingTrip->recalculateTotal();
        });

        static::deleted(function ($item) {
            if ($item->shoppingTrip) {
                $item->shoppingTrip->recalculateTotal();
            }
        });
    }

    /**
     * Scope để tìm theo tên món đồ
     */
    public function scopeByName($query, $name)
    {
        return $query->where('item_name', 'LIKE', "%{$name}%");
    }

    /**
     * Scope để lọc theo tháng (qua shopping_trip)
     */
    public function scopeInMonth($query, $month, $year)
    {
        return $query->whereHas('shoppingTrip', function ($q) use ($month, $year) {
            $q->whereMonth('shopping_date', $month)
              ->whereYear('shopping_date', $year);
        });
    }

    /**
     * Lấy top các món đồ được mua nhiều nhất trong tháng
     */
    public static function getTopItemsByMonth($month, $year, $limit = 10)
    {
        return self::inMonth($month, $year)
                   ->selectRaw('item_name, COUNT(*) as frequency, SUM(total_price) as total_spent, AVG(price) as avg_price')
                   ->groupBy('item_name')
                   ->orderByDesc('frequency')
                   ->orderByDesc('total_spent')
                   ->limit($limit)
                   ->get();
    }

    /**
     * Lấy top các món đồ đắt nhất trong tháng
     */
    public static function getMostExpensiveItemsByMonth($month, $year, $limit = 10)
    {
        return self::inMonth($month, $year)
                   ->with('shoppingTrip:id,shopping_date')
                   ->orderByDesc('total_price')
                   ->limit($limit)
                   ->get();
    }

    /**
     * Tìm kiếm món đồ để gợi ý (autocomplete)
     */
    public static function getItemSuggestions($search = '', $limit = 10)
    {
        return self::select('item_name')
                   ->when($search, function ($query, $search) {
                       return $query->where('item_name', 'LIKE', "%{$search}%");
                   })
                   ->groupBy('item_name')
                   ->orderByRaw('COUNT(*) DESC')
                   ->limit($limit)
                   ->pluck('item_name');
    }

    /**
     * Accessor để format giá tiền
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price) . ' VNĐ';
    }

    /**
     * Accessor để format thành tiền
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_price) . ' VNĐ';
    }

    /**
     * Accessor để hiển thị quantity với đơn vị
     */
    public function getFormattedQuantityAttribute()
    {
        // Nếu quantity là số nguyên thì không hiển thị phần thập phân
        $qty = $this->quantity == (int)$this->quantity ? (int)$this->quantity : $this->quantity;
        return $qty;
    }

    /**
     * Mutator để đảm bảo tên món đồ được capitalize
     */
    public function setItemNameAttribute($value)
    {
        $this->attributes['item_name'] = ucwords(strtolower(trim($value)));
    }
}
