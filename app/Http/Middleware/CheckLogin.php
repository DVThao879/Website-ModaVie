<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdminOrStaff()) {
            return $next($request);
        }
        
        // Thêm thông báo rõ ràng hơn
        return redirect()->route('admin.loginForm')->with('warning', 'Vui lòng đăng nhập để vào trang quản trị!');
    }
    
}
