<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    const PATH_VIEW = 'admin.accounts.';
    const PATH_UPLOAD = 'users';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $data = User::whereIn('role', ['1', '2'])->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->except('image');
        $data['password'] = Hash::make($request->input('password'));

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('users', $request->file('image'));
        } else {
            $data['image'] = '';
        }

        $data['email_verified_at'] = now();
        $data['role'] = '1';
        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view(self::PATH_VIEW . __FUNCTION__, compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view(self::PATH_VIEW . __FUNCTION__, compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->all();
        if ($user->email_verified_at == null) {
            $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = $user->email_verified_at;
        }
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        if (!empty($user->image) && Storage::exists($user->image)) {
            Storage::delete($user->image);
        }
        $user->delete();
        return back()->with('success', 'Xóa thành công');
    }

    public function listUser()
    {
        $this->authorize('viewAny', User::class);
        $data = User::where('role', '0')->orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . 'list_user', compact('data'));
    }

    public function logout()
    {
        Auth::logout();
        \request()->session()->invalidate();
        return redirect()->route('admin.loginForm')->with('success', 'Đăng xuất thành công');
    }

    public function profile()
    {
        return view(self::PATH_VIEW . 'profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Tên là bắt buộc',
            'name.max' => 'Tối đa 255 kí tự',
            'address.required' => 'Địa chỉ là bắt buộc',
            'address.max' => 'Tối đa 255 kí tự',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'image.image' => 'Tệp tải lên phải là hình ảnh',
            'image.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif',
            'image.max' => 'Ảnh đại diện không được lớn hơn 2MB',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $data = $request->except('image', 'email');

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('users', $request->file('image'));
            if (!empty($user->image) && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }
        } else {
            $data['image'] = $user->image;
        }

        $user->update($data);

        return redirect()->route('admin.profile')->with('success', 'Cập nhật thông tin thành công');
    }

    public function showChangePasswordForm()
    {
        return view('admin.accounts.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'],
            'new_password_confirmation' => 'required|string',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.regex' => 'Mật khẩu bao gồm chữ in hoa, chữ cái thường và số',
            'new_password.min' => 'Mật khẩu mới phải ít nhất 8 ký tự',
            'new_password.confirmed' => 'Mật khẩu mới không trùng khớp',
            'new_password_confirmation.required' => 'Vui lòng không bỏ trống',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        if (Hash::check($request->new_password, auth()->user()->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu hiện tại']);
        }

        // Cập nhật mật khẩu mới
        $user = User::findOrFail(auth()->user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        Auth::logout();

        return redirect()->route('home')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
    }
}
