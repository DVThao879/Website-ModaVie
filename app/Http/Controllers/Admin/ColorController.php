<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Http\Requests\StoreColorRequest;
use App\Http\Requests\UpdateColorRequest;
use App\Models\Product;
use App\Models\ProductVariant;

class ColorController extends Controller
{
    const PATH_VIEW = 'admin.colors.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Color::class);
        $data = Color::orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Color::class);
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
        Color::create($request->all());
        return redirect()->route('admin.colors.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        $this->authorize('view', $color);
        return view(self::PATH_VIEW . __FUNCTION__, compact('color'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        $this->authorize('update', $color);
        return view(self::PATH_VIEW . __FUNCTION__, compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color)
    {
        $color->update($request->all());
        return redirect()->route('admin.colors.index')->with('success', 'Sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $this->authorize('delete', $color);

        // Lấy tất cả các biến thể liên quan đến màu này
        $variants = ProductVariant::where('color_id', $color->id)->get();

        // Xóa màu
        $color->delete();

        // Kiểm tra và cập nhật lại trạng thái sản phẩm nếu cần
        foreach ($variants as $variant) {
            $productId = $variant->product_id;

            // Đếm số lượng biến thể còn lại của sản phẩm sau khi xóa
            $remainingVariants = ProductVariant::where('product_id', $productId)->count();

            // Nếu không còn biến thể, cập nhật is_active về 0
            if ($remainingVariants == 0) {
                $product = Product::find($productId);
                $product->is_active = 0;
                $product->save();
            }
        }

        return back()->with('success', 'Xóa màu thành công');
    }
}
