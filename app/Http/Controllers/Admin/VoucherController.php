<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;

class VoucherController extends Controller
{
    const PATH_VIEW = 'admin.vouchers.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Voucher::class);
        $data = Voucher::orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Voucher::class);
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        $data = $request->all();
        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm Voucher thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        $this->authorize('view', $voucher);
        return view(self::PATH_VIEW.__FUNCTION__, compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        $this->authorize('update', $voucher);
        return view(self::PATH_VIEW . __FUNCTION__, compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $data = $request->all();
        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')->with('success', 'Sửa Voucher thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $this->authorize('delete', $voucher);
        $voucher->delete();
        return back()->with('success', 'Xóa thành công');
    }
}
