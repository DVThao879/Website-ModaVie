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
        ],[
            'email'=>'Email không được bỏ trống',
            'password'=>'Mật khẩu không được bỏ trống'
        ]);
        $remember = $request->has('remember');
        if (Auth::attempt($credentials,$remember)) {
            // Kiểm tra xem email đã được xác thực chưa
            if (Auth::user()->email_verified_at === null) {
                // Đăng xuất ngay lập tức nếu chưa xác thực
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email chưa được xác minh,vui lòng kiểm tra hộp thư',
                ])->onlyInput('email');
            }
            if(Auth::user()->is_active==0){
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa, vui lòng liên hệ với quản trị viên.',
                ]);
            }
                $request->session()->regenerate();
            return redirect()->route('home')->with('success','Đăng nhập thành công');
        }
    
        return back()->withErrors([
            'email' => 'Thông tin không chính xác,vui lòng kiểm tra lại',
        ])->onlyInput('email');
    }
    

    public function logout() {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect()->route('home')->with('success','Đăng xuất thành công');
    }

    public function verify($token)
    {
        $user = User::query()
            ->where('email', base64_decode($token))
            ->where('email_verified_at', null)
            ->where('email_verification_expires_at', '>', Carbon::now()) // Kiểm tra thời gian hết hạn
            ->first();
    
        if ($user) {
            $user->update(['email_verified_at' => Carbon::now()]);
            Auth::login($user);
            \request()->session()->regenerate();
            return redirect()->intended('/');
        }
    
        // Nếu thời gian xác thực đã hết hạn, thông báo lỗi
        return redirect('user/auth/login')->withErrors([
            'email' => 'Liên kết xác thực đã hết hạn, vui lòng yêu cầu liên kết mới.',
        ]);
    }
    
   
}
