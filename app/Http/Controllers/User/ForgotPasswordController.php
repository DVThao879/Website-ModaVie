<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailPassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgotForm(){
        return view('client.show.forgotpassword');
    }

    public function forgot(Request $request){
        $request->validate(['email' => 'required|email'],[
            'email.required' => 'Vui lòng nhập email'
        ]);

        // Kiểm tra xem email đã được xác thực chưa
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.']);
        }

        if (!$user->hasVerifiedEmail()) {
            return back()->withErrors(['email' => 'Email chưa được xác thực. Vui lòng kiểm tra hộp thư của bạn.']);
        }

        // Tạo token và gửi email xác thực
        $token = base64_encode($user->email);
        Mail::to($user->email)->send(new VerifyEmailPassword($user->name, $token));

        return redirect()->route('forgot')->with('status', 'Link xác thực đã được gửi, vui lòng kiểm tra email của bạn.');
    }
    public function verifyEmail($token) {
        $email = base64_decode($token);
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Email không hợp lệ.']);
        }
    
        // Đánh dấu email đã được xác thực
        $user->email_verified_at = now();
        $user->save();
    
        return redirect()->route('password.reset', ['token' => $token])->with('status', 'Email đã được xác thực. Bạn có thể đặt lại mật khẩu.');
    }


    public function showResetForm($token)
    {
        // Giải mã token để lấy email
        $email = base64_decode($token);
    
        // Truyền token và email vào view
        return view('client.show.password', [
            'token' => $token,
            'email' => $email
        ]);
    }
    

    public function reset(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        // 'token' => 'required',
        // 'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ],[
        'password.required'=>'Vui lòng không được bỏ trống',
        'password.min'=>'Mật khẩu ít nhất 8 ký tự',
        'password.confirmed'=>'Mật khẩu không trùng khớp'
    ]);

    // Tìm người dùng dựa trên email
    $user = User::where('email', $request->email)->first();

    // Kiểm tra người dùng có tồn tại không
    if (!$user) {
        return back()->withErrors(['email' => 'Email không hợp lệ.']);
    }

    // Cập nhật mật khẩu cho người dùng
    $user->password = Hash::make($request->password);
    $user->save();
    return redirect()->route('login')->with('status', 'Mật khẩu đã được đổi thành công!');
}

}
