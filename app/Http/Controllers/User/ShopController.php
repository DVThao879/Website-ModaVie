<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $id = null)
    {
        // Kiểm tra xem có yêu cầu sắp xếp không
        $sort = $request->input('sort'); // Lấy giá trị sắp xếp từ request
    
        // Xử lý trường hợp lọc theo danh mục
        if ($id) {
            $query = Product::query()
                ->where('category_id', $id)
                ->where('is_active', 1)
                ->with('category', 'variants.color');
        } else {
            // Hiển thị tất cả sản phẩm
            $query = Product::query()
                ->where('is_active', 1)
                ->with('category', 'variants.color');
        }
    
        // Áp dụng sắp xếp nếu có
        if ($sort) {
            switch ($sort) {
                case 'price_low_to_high':
                    $query->orderBy(ProductVariant::select('price_sale')
                    ->whereColumn('product_variants.product_id', 'products.id')
                    ->limit(1), 'asc');
                    break;
                case 'price_high_to_low':
                    $query->orderBy(ProductVariant::select('price_sale')
                    ->whereColumn('product_variants.product_id', 'products.id')
                    ->limit(1), 'desc');
                    break;
                case 'a_to_z':
                    $query->orderBy('name', 'asc');
                    break;
                case 'z_to_a':
                    $query->orderBy('name', 'desc');
                    break;
              
                default:
                    $query->latest('id'); // Mặc định sắp xếp theo id mới nhất
                    break;
            }
        } else {
            $query->latest('id'); // Nếu không có yêu cầu sắp xếp, sắp xếp theo id mới nhất
        }
    
        // Lấy sản phẩm với phân trang
        $products = $query->paginate(8);
        
        $noResults = $products->isEmpty();
    
        // Lấy danh mục
        $categories = Category::query()
            ->where('is_active', 1) 
            ->withCount(['products' => function ($query) {
                $query->where('is_active', 1); 
            }])
            ->get();
    
        // Lấy tất cả các màu sắc của các biến thể, loại bỏ màu trùng lặp
        $allColors = collect();
    
        foreach ($products as $product) {
            foreach ($product->variants as $variant) {
                if ($variant->color) {
                    $allColors->push($variant->color);
                }
            }
        }
    
        $allColors = $allColors->unique('hex_code');
    
        // Tính tổng số sản phẩm
        $totalproducts = $categories->sum('products_count');
    
        // Trả về view với dữ liệu đã xử lý
        return view('client.show.shop', compact('products', 'categories', 'totalproducts', 'allColors', 'noResults'));
    }
    
    public function detail($slug)
    {
        $product = Product::query()->where('slug', $slug)
            ->with(['variants', 'category', 'galleries','comments.user'])->first();
        // dd($product);
        $productVariants = $product->variants->all();
        $colorIds = [];
        $sizeIds = [];

        foreach ($productVariants as $item) {
            $colorIds[] = $item->color_id;
            $sizeIds[] = $item->size_id;
        }
        $comments = $product->comments()->orderBy('id', 'desc')->paginate(3);

        // Lấy mã màu từ bảng Color
        $colors = Color::query()->whereIn('id', $colorIds)
            ->pluck('name', 'id')->all();

        $sizes = Size::query()->whereIn('id', $sizeIds)
            ->pluck('name', 'id')->all();
        Product::query()->where('slug', $slug)->increment('view');

        $sanpham_cung_loai = Product::query()->where('id', '!=', $product->id)->where('category_id', $product->category->id)->limit(4)->distinct()->get();
        // dd($sanpham_cung_loai);
        return view('client.show.product_detail', compact('product', 'colors', 'sizes', 'sanpham_cung_loai','comments'));
    }

    // Chi tiết sản phẩm
    public function getProductVariantPrice(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($product) {
            $productVariant = $product->variants->where('size_id', $request->size)
                ->where('color_id', $request->color)
                ->first();

            if ($productVariant) {
                $price_sale = $productVariant->price_sale;
                $price = $productVariant->price;
                $quantity = $productVariant->quantity;
                return response()->json([
                    'success' => true,
                    'price_sale' => number_format($price_sale, 0, ',', '.'),
                    'price' => number_format($price, 0, ',', '.'),

                    'quantity' => $quantity
                ]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function getColorsBySize(Request $request)
    {
        $sizeId = $request->input('size');
        $productId = $request->input('product_id');

        $colors = ProductVariant::where('product_id', $productId)
            ->where('size_id', $sizeId)
            ->pluck('color_id')
            ->toArray();

        $availableColors = Color::whereIn('id', $colors)->pluck('name', 'id');

        if ($availableColors->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'colors' => $availableColors,
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    // Tìm kiếm sản phẩm
 public function search(Request $request)
{
    $keyword = $request->input('keyword');
    
    // Nếu không có từ khóa tìm kiếm, chuyển hướng về trang shop ban đầu
    if (empty($keyword)) {
        return redirect('/shop');
    }

    // Tìm sản phẩm theo từ khóa
    $products = Product::query()
        ->where('name', 'LIKE', "%{$keyword}%")
        ->with('category', 'variants.color')
        ->paginate(8);

    $noResults = $products->isEmpty();
    $categories = Category::withCount('products')->get();
    $totalproducts = $categories->sum('products_count');

    // Lấy các màu sắc cho sản phẩm
    $allColors = collect();
    foreach ($products as $product) {
        foreach ($product->variants as $variant) {
            if ($variant->color) {
                $allColors->push($variant->color);
            }
        }
    }
    $allColors = $allColors->unique('hex_code');

    // Trả về kết quả với trang sản phẩm
    return view('client.show.shop', compact('products', 'categories', 'totalproducts', 'allColors', 'noResults'))
        ->with('keyword', $keyword);
}

}
