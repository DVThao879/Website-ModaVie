<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(Auth::check() && Auth::user()->isAdminOrStaff()){
            return $next($request);
           }
           
           return redirect()->route('admin.loginForm')->with('warning','Vui lòng đăng nhập để vào trang quản trị !');
        
        }
}
