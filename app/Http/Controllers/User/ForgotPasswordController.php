<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
       // Cập nhật thời gian hết hạn cho email xác thực (30 phút)
       $user->update([
        'email_verification_expires_at' => Carbon::now()->addMinutes(30)
    ]);
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
     // Kiểm tra xem thời gian xác thực có còn hợp lệ hay không
     if (Carbon::now()->greaterThan($user->email_verification_expires_at)) {
        return redirect()->route('forgot')->withErrors(['email' => 'Link xác thực đã hết hạn. Vui lòng yêu cầu gửi lại link.']);
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
        $request->validate([
           
            'password' => 'required|confirmed|min:8',
        ],[
            
            'password.required'=>'Vui lòng không được bỏ trống',
            'password.min'=>'Mật khẩu ít nhất 8 ký tự',
            'password.confirmed'=>'Mật khẩu không trùng khớp'
        ]);
    // dd($request->email);
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
