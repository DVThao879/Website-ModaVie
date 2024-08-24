<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AcountController extends Controller
{
    function myAucount(){
        return view('client.show.my_acount');
    }
    public function updateMyAcount(Request $request, $id)
    {
        $user = User::findOrFail($id);

    // Xử lý cập nhật thông tin cá nhân
    if (Auth::check()) {
        $image = Auth::user()->image;
    }

    if ($request->hasFile('image')) {
        $url = Storage::put('user', $request->file('image'));
    } else {
        $url = $image;
    }

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'phone' => $request->phone,
        'image' => $url,
    ]);

    // Xử lý cập nhật mật khẩu nếu người dùng yêu cầu
    if ($request->filled('current_password') || $request->filled('new_password')) {
        $request->validate([
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại nếu muốn thay đổi mật khẩu.',
            'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu mới không trùng khớp.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->new_password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    
}
