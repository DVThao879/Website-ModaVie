<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class CheckLoginController extends Controller
{
    public function loginForm(){
        return view('admin.accounts.login');
    }
    public function login(Request $request) {
        $maxAttempts = 3;
        $decayMinutes = 15;
        // Kiểm tra nếu người dùng bị khóa tạm thời
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), $maxAttempts)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request)); 
            $minutes = floor($seconds / 60);
            $remainingSeconds = $seconds % 60; 
        
            return back()->withErrors([
                'err' => 'Vui lòng thử lại sau ' . $minutes . ' phút ' . $remainingSeconds . ' giây.',
            ])->onlyInput('email');
        }
        $login = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[
            'email.email'=>'Email không đúng định dạng',
            'email.required'=>'Email không được bỏ trống',
            'password.required'=>'Password không được bỏ trống'
        ]);
        
        $remember = $request->has('remember');
        if (Auth::attempt($login,$remember)) {
            RateLimiter::clear($this->throttleKey($request)); 
            $request->session()->regenerate();
            
            $user = Auth::user();

            if($user->is_active == 0){
                Auth::logout(); 
                return back()->withErrors([
                    'err' => 'Tài khoản của bạn hiện tại không hoạt động', 
                ]);
            }
            if($user->email_verified_at == null){
                Auth::logout(); 
                return back()->withErrors([
                    'err' => 'Tài khoản của bạn chưa xác thực! Vui lòng đăng nhập bên client để xác minh', 
                ]);
            }
           
            if ($user->role==2 || $user->role==1) { 
                $request->session()->put('user_name', $user->name);
                return redirect()->intended('admin')->with('success', 'Đăng nhập thành công!');
            } else {
                Auth::logout(); 
                return back()->withErrors([
                    'err' => 'Bạn không có quyền truy cập vào trang admin',
                ])->onlyInput('err');
            }

        }
        RateLimiter::hit($this->throttleKey($request), $decayMinutes * 60);

        return back()->withErrors([
            'err' => 'Thông tin đăng nhập không tồn tại',
        ])->onlyInput('err');
    }
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip(); // Tạo khóa duy nhất dựa trên email và địa chỉ IP của người dùng
    }
}
