<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;

class SizeController extends Controller
{
    const PATH_VIEW = 'admin.sizes.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Size::all();
        return view(self::PATH_VIEW.__FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        Size::create($request->all());
        return redirect()->route('admin.sizes.index')->with('message', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        return view(self::PATH_VIEW.__FUNCTION__, compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view(self::PATH_VIEW.__FUNCTION__, compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $size->update($request->all());
        return redirect()->route('admin.sizes.index')->with('message', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return back()->with('message', 'Xóa thành công');
    }
}
