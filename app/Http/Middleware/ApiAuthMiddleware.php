<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request for API routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra API token hoặc session
        $token = $request->header('Authorization') ?: $request->get('api_token');

        if ($token) {
            // Kiểm tra Bearer token
            if (str_starts_with($token, 'Bearer ')) {
                $token = substr($token, 7);
            }

            // Simple token check (có thể cải thiện bằng JWT)
            if ($this->isValidApiToken($token)) {
                return $next($request);
            }
        }

        // Fallback: check session như web routes
        if (session()->has('app_authenticated')) {
            $loginTime = session('app_login_time');
            if ($loginTime && now()->diffInHours($loginTime) <= 24) {
                return $next($request);
            }
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Vui lòng đăng nhập để sử dụng API.'
        ], 401);
    }

    /**
     * Kiểm tra API token có hợp lệ không
     */
    private function isValidApiToken($token)
    {
        // Simple implementation - có thể cải thiện
        $validTokens = [
            'family_app_2771211_' . date('Ymd'), // Token đổi theo ngày
            session()->getId() . '_authenticated' // Session-based token
        ];

        return in_array($token, $validTokens);
    }
}
