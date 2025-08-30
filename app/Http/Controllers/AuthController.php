<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AppSetting;

class AuthController extends Controller
{
    /**
     * Hiển thị trang login
     */
    public function showLoginForm()
    {
        // Nếu đã đăng nhập rồi thì redirect về trang chủ
        if (session()->has('app_authenticated')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu.'
        ]);

        // Lấy mật khẩu từ database
        $appPassword = AppSetting::where('key', 'app_password')->first();

        if (!$appPassword) {
            // Nếu chưa có trong DB, tạo mật khẩu mặc định
            AppSetting::create([
                'key' => 'app_password',
                'value' => Hash::make('2771211'),
                'description' => 'Mật khẩu bảo vệ ứng dụng'
            ]);
            $appPassword = AppSetting::where('key', 'app_password')->first();
        }

        // Check mật khẩu
        if (Hash::check($request->password, $appPassword->value)) {
            // Đăng nhập thành công
            session([
                'app_authenticated' => true,
                'app_login_time' => now()
            ]);

            return redirect()->route('dashboard')->with('success', 'Đăng nhập thành công!');
        }

        // Sai mật khẩu
        return back()->withErrors([
            'password' => 'Mật khẩu không đúng. Vui lòng thử lại.'
        ])->withInput();
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        session()->forget(['app_authenticated', 'app_login_time']);
        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công.');
    }

    /**
     * Đổi mật khẩu
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed'
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.'
        ]);

        $appPassword = AppSetting::where('key', 'app_password')->first();

        // Check mật khẩu hiện tại
        if (!Hash::check($request->current_password, $appPassword->value)) {
            return back()->withErrors([
                'current_password' => 'Mật khẩu hiện tại không đúng.'
            ]);
        }

        // Cập nhật mật khẩu mới
        $appPassword->update([
            'value' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
