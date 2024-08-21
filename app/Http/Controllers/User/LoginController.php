<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        // hiển thị form login
        return view('client.show.login');
    }

    public function login(Request $request) {
        // Xử lý logic login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            // Kiểm tra xem email đã được xác thực chưa
            if (Auth::user()->email_verified_at === null) {
                // Đăng xuất ngay lập tức nếu chưa xác thực
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email chưa được xác minh,vui lòng kiểm tra hộp thư',
                ])->onlyInput('email');
            }
                $request->session()->regenerate();
            return redirect()->intended('/');
        }
    
        return back()->withErrors([
            'email' => 'Thông tin không chính xác,vui lòng kiểm tra lại',
        ])->onlyInput('email');
    }
    

    public function logout() {
        // xử lý logout
        Auth::logout();
        \request()->session()->invalidate();
        return redirect('/');
    }

    public function verify($token) {
        $user = User::query()->where('email', base64_decode($token))
            ->where('email_verified_at', null)->first();
        if ($user) {
            $user->update(['email_verified_at' => Carbon::now()]);
            // Login bằng tk user
            Auth::login($user);
            // generate lại token
            \request()->session()->regenerate();
            return redirect()->intended('/');
        }
    }
}
