<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductGallery;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    const PATH_VIEW = 'admin.products.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);
        $data = Product::with('variants')->orderBy('id', 'desc')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        $categories = Category::where('is_active', 1)->get();
        $sizes = Size::all();
        $colors = Color::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories', 'sizes', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->except(['variants', 'img_thumb', 'product_galleries']);
        $data['slug'] = Str::slug($data['name']);
        $uploadedFiles = [];
        if (!empty($request->hasFile('img_thumb'))) {
            $data['img_thumb'] = Storage::put('products', $request->file('img_thumb'));
        }

        try {
            DB::beginTransaction();

            // Tạo sản phẩm
            $product = Product::create($data);

            // Xử lý hình ảnh gallery nếu có
            if ($request->hasFile('product_galleries')) {
                foreach ($request->file('product_galleries') as $image) {
                    $imagePath = Storage::put('product_galleries', $image);
                    $uploadedFiles[] = $imagePath;
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                    ]);
                }
            }

            // Xử lý các biến thể nếu có
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'size_id' => $variant['size_id'],
                            'color_id' => $variant['color_id'],
                        ],
                        [
                            'quantity' => !empty($variant['quantity']) ? $variant['quantity'] : 0,
                            'price' => !empty($variant['price']) ? $variant['price'] : 0,
                            'price_sale' => !empty($variant['price_sale']) ? $variant['price_sale'] : 0,
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Thêm mới thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($data['img_thumb'])) {
                Storage::delete($data['img_thumb']);
            }

            foreach ($uploadedFiles as $file) {
                Storage::delete($file);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra. Thêm mới thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        $product->load(['galleries', 'variants.size', 'variants.color']);
        return view(self::PATH_VIEW . __FUNCTION__, compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $product->load(['variants', 'galleries']);
        $categories = Category::where('is_active', 1)
        ->orWhere('id', $product->category_id)
        ->get();
        $sizes = Size::all();
        $colors = Color::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('product', 'categories', 'sizes', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->except(['variants', 'img_thumb', 'product_galleries']);
        $data['slug'] = Str::slug($data['name']);
        $uploadedFiles = [];
        if ($request->hasFile('img_thumb')) {
            if ($product->img_thumb && Storage::exists($product->img_thumb)) {
                Storage::delete($product->img_thumb);
            }
            $data['img_thumb'] = Storage::put('products', $request->file('img_thumb'));
        }

        try {
            DB::beginTransaction();

            // Cập nhật sản phẩm
            $product->update($data);

            // Xử lý hình ảnh gallery nếu có
            if ($request->hasFile('product_galleries')) {
                // Xóa hình ảnh gallery cũ nếu cần
                $existingGalleries = $product->galleries;
                foreach ($existingGalleries as $gallery) {
                    Storage::delete($gallery->image);
                    $gallery->delete();
                }

                foreach ($request->file('product_galleries') as $image) {
                    $imagePath = Storage::put('product_galleries', $image);
                    $uploadedFiles[] = $imagePath;
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $imagePath,
                    ]);
                }
            }

            // Xử lý các biến thể nếu có
            if ($request->has('variants')) {
                // Lấy tất cả các biến thể hiện tại của sản phẩm
                $existingVariants = $product->variants->keyBy(function ($variant) {
                    return $variant->size_id . '-' . $variant->color_id;
                });

                foreach ($request->variants as $variant) {
                    $variantKey = $variant['size_id'] . '-' . $variant['color_id'];

                    // Cập nhật hoặc tạo mới biến thể
                    ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'size_id' => $variant['size_id'],
                            'color_id' => $variant['color_id'],
                        ],
                        [
                            'quantity' => !empty($variant['quantity']) ? $variant['quantity'] : 0,
                            'price' => !empty($variant['price']) ? $variant['price'] : 0,
                            'price_sale' => !empty($variant['price_sale']) ? $variant['price_sale'] : 0,
                        ]
                    );

                    // Xóa biến thể đã tồn tại nhưng không có trong dữ liệu gửi lên
                    if ($existingVariants->has($variantKey)) {
                        $existingVariants->forget($variantKey);
                    }
                }

                // Xóa các biến thể còn lại trong danh sách đã xóa
                foreach ($existingVariants as $variant) {
                    $variant->delete();
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Sửa thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($data['img_thumb'])) {
                Storage::delete($data['img_thumb']);
            }

            foreach ($uploadedFiles as $file) {
                Storage::delete($file);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra. Sửa thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        try {
            DB::beginTransaction();

            if ($product->img_thumb) {
                Storage::delete($product->img_thumb);
            }
    
            $galleries = $product->galleries;
            foreach ($galleries as $gallery) {
                if ($gallery->image) {
                    Storage::delete($gallery->image);
                }
            }

            $product->delete();
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Xóa thất bại');
        }
    }
}
