<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description'
    ];

    /**
     * Lấy giá trị setting theo key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set giá trị setting
     */
    public static function set($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description
            ]
        );
    }

    /**
     * Lấy quỹ hiện tại
     */
    public static function getCurrentFundBalance()
    {
        return (int) self::get('current_fund_balance', 0);
    }

    /**
     * Cập nhật quỹ hiện tại
     */
    public static function updateFundBalance($newBalance)
    {
        return self::set('current_fund_balance', $newBalance, 'Số dư quỹ hiện tại');
    }

    /**
     * Lấy danh sách tên thành viên
     */
    public static function getUserNames()
    {
        $names = self::get('user_names', '["Tôi", "Anh Hai"]');
        return json_decode($names, true);
    }
}
