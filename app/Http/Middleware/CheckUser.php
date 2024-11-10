<?php

namespace App\Http\Middleware;
use App\Models\User;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next) { 
        if (Auth::check() && Auth::user()->role != User::ADMIN_ROLE) { 
            return $next($request); 
        } 
        return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để truy cập!'); }
}
