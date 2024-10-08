<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
// use Illuminate\Http\Request;
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
        $this->authorize('viewAny', User::class);
        $data = User::whereIn('role', [1, 2])->orderBy('role', 'desc')->orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

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
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        if(!empty($user->image) && Storage::exists($user->image)){
            Storage::delete($user->image);
        }
        $user->delete();
        return back()->with('success', 'Xóa thành công');
    }

    public function listUser()
    {
        $this->authorize('viewAny', User::class);
        $data = User::where('role', 0)->orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . 'list_user', compact('data'));
    }
}
