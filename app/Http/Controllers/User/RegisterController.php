<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class RegisterController extends Controller
{
    public function index() {
        // hiển thị view đăng ký
//        dd('trang đăng ký');
        return view('client.show.register');
    }

    public function register(Request $request) {
        // xử lý logic đăng ký
//        dd($request->all());
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email'=> ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],[

            'name.required' =>'Vui lòng nhập tên',
            'email.required'=>'Vui lòng nhập email',
            'email.unique'=>'Email đã tồn tại',
            'password.min'=>'Mật khẩu phải ít nhất 8 ký tự',
            'password.required'=>'Vui lòng không bỏ trống',
            'password.confirmed'=>'Mật khẩu không trùng khớp'
             
        ]);

        // tạo tài khoản
        $user = User::query()->create($data);
        //     // Kiểm tra nếu đã gửi email xác thực và chưa hết hạn thì không gửi lại
        // if ($user->email_verification_expires_at && $user->email_verification_expires_at->isFuture()) {
        //     return redirect()->route('login')->withErrors([
        //         'email' => 'Email xác thực đã được gửi, vui lòng kiểm tra hộp thư hoặc chờ liên kết hết hạn để gửi lại.',
        //     ]);
        // }
            // Cập nhật thời gian hết hạn cho email xác thực (30 phút)
    $user->update([
        'email_verification_expires_at' => Carbon::now()->addMinutes(30)
    ]);
        // Gửi email xác nhận
        $token = base64_encode($user->email);
        Mail::to($user->email)->send(new VerifyEmail($user->name, $token));

//        // Login bằng tk user vừa tạo
//        Auth::login($user);
//        // generate lại token
//        $request->session()->regenerate();
        return redirect()->route('user.login')->with('status', 'Đăng ký thành công, vui lòng xác thực email.');
    }
}
