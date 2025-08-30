<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu đang truy cập trang login thì cho phép
        if ($request->routeIs('login') || $request->routeIs('auth.login')) {
            return $next($request);
        }

        // Check xem đã đăng nhập chưa
        if (!session()->has('app_authenticated')) {
            // Nếu chưa đăng nhập, redirect về trang login
            return redirect()->route('login')->with('error', 'Vui lòng nhập mật khẩu để truy cập ứng dụng.');
        }

        // Check thời gian hết hạn session (24 giờ)
        $loginTime = session('app_login_time');
        if ($loginTime && now()->diffInHours($loginTime) > 24) {
            // Hết hạn session, xóa và redirect về login
            session()->forget(['app_authenticated', 'app_login_time']);
            return redirect()->route('login')->with('error', 'Phiên làm việc đã hết hạn. Vui lòng đăng nhập lại.');
        }

        return $next($request);
    }
}
