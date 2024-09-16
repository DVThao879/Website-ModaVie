<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    const PATH_VIEW = 'admin.accounts.';
    const PATH_UPLOAD = 'users';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::orderBy('role', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.users.index')->with('error', 'Chức năng này không khả dụng');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.users.index')->with('error', 'Chức năng này không khả dụng');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Auth::user()->role == 2) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể sửa tài khoản này');
        }
        return view(self::PATH_VIEW . __FUNCTION__, compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role == 2) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể cập nhật tài khoản này');
        } 
        $data = $request->all();
        $data['is_active'] ??= 0;
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role == 2) {
            return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản này');
        }

        if(!empty($user->image) && Storage::exists($user->image)){
            Storage::delete($user->image);
        }
        $user->delete();
        return back()->with('success', 'Xóa thành công');
    }
}
