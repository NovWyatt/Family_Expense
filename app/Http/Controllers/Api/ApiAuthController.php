<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    /**
     * API Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        // Lấy mật khẩu từ database
        $appPassword = AppSetting::where('key', 'app_password')->first();

        if (!$appPassword || !Hash::check($request->password, $appPassword->value)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu không đúng.'
            ], 401);
        }

        // Tạo session
        session([
            'app_authenticated' => true,
            'app_login_time' => now()
        ]);

        // Tạo simple API token
        $token = 'family_app_2771211_' . date('Ymd');

        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thành công!',
            'token' => $token,
            'expires_in' => 24 * 60 * 60, // 24 giờ
            'user' => [
                'names' => AppSetting::getUserNames(),
                'current_balance' => AppSetting::getCurrentFundBalance()
            ]
        ]);
    }

    /**
     * API Logout
     */
    public function logout(Request $request)
    {
        session()->forget(['app_authenticated', 'app_login_time']);

        return response()->json([
            'success' => true,
            'message' => 'Đã đăng xuất thành công.'
        ]);
    }

    /**
     * Check authentication status
     */
    public function check(Request $request)
    {
        $isAuthenticated = session()->has('app_authenticated');
        $loginTime = session('app_login_time');

        if ($isAuthenticated && $loginTime) {
            $hoursLeft = 24 - now()->diffInHours($loginTime);

            return response()->json([
                'authenticated' => true,
                'hours_left' => max(0, $hoursLeft),
                'current_balance' => AppSetting::getCurrentFundBalance(),
                'user_names' => AppSetting::getUserNames()
            ]);
        }

        return response()->json([
            'authenticated' => false,
            'message' => 'Chưa đăng nhập hoặc phiên đã hết hạn.'
        ]);
    }
}
