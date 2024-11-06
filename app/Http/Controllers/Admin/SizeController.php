<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use App\Models\Product;
use App\Models\ProductVariant;

class SizeController extends Controller
{
    const PATH_VIEW = 'admin.sizes.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Size::class);
        $data = Size::orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Size::class);
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSizeRequest $request)
    {
        Size::create($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        $this->authorize('view', $size);
        return view(self::PATH_VIEW . __FUNCTION__, compact('size'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        $this->authorize('update', $size);
        return view(self::PATH_VIEW . __FUNCTION__, compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $size->update($request->all());
        return redirect()->route('admin.sizes.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $this->authorize('delete', $size);

        // Lấy tất cả các biến thể liên quan đến size này
        $variants = ProductVariant::where('size_id', $size->id)->get();

        // Xóa size
        $size->delete();

        // Kiểm tra và cập nhật lại trạng thái sản phẩm nếu cần
        foreach ($variants as $variant) {
            $productId = $variant->product_id;

            // Đếm số lượng biến thể còn lại của sản phẩm sau khi xóa
            $count = ProductVariant::where('product_id', $productId)->count();

            // Nếu không còn biến thể, cập nhật is_active về 0
            if ($count == 0) {
                $product = Product::find($productId);
                $product->is_active = 0;
                $product->save();
            }
        }

        return back()->with('success', 'Xóa size thành công');
    }
}
