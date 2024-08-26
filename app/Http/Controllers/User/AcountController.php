<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
    
        if (Auth::check()) {
            $image = Auth::user()->image;
        }
    
        if ($request->hasFile('image')) {
            $url = Storage::put('user', $request->file('image'));
            Storage::delete($image); // Delete old image if exists
        } else {
            $url = $image;
        }
    
        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->image = $url;
    
        // Handle password update
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
