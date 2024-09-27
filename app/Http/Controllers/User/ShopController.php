<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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
    // Xử lý trường hợp lọc theo danh mục
    if ($id) {
        $products = Product::query()
            ->where('category_id', $id)
            ->where('is_active',1)
            ->with('category', 'variants.color')
            ->latest('id')
            ->paginate(8); 
    } else {
        // Hiển thị tất cả sản phẩm
        $products = Product::query()
            ->latest('id')
            ->where('is_active',1)
            ->with('category', 'variants.color')
            ->paginate(8);
    }

    // Lấy tất cả các danh mục
    $categories = Category::query()->withCount('products')->get();

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

   
    return view('client.show.shop', compact('products', 'categories', 'totalproducts', 'allColors'));
}
    public function detail($slug) {
        $product = Product::query()->where('slug', $slug)
            ->with(['variants', 'category', 'galleries'])->first();
    // dd($product);
        $productVariants = $product->variants->all();
        $colorIds = [];
        $sizeIds = [];
    
        foreach ($productVariants as $item) {
            $colorIds[] = $item->color_id;
            $sizeIds[] = $item->size_id;
        }
    
        // Lấy mã màu từ bảng Color
        $colors = Color::query()->whereIn('id', $colorIds)
            ->pluck('name', 'id')->all();
    
        $sizes = Size::query()->whereIn('id', $sizeIds)
            ->pluck('name', 'id')->all();
        Product::query()->where('slug',$slug)->increment('view');

            $sanpham_cung_loai=Product::query()->where('id','!=',$product->id)->where('category_id',$product->category->id)->limit(4)->distinct()->get();
            // dd($sanpham_cung_loai);
        return view('client.show.product_detail', compact('product', 'colors', 'sizes','sanpham_cung_loai'));
    }
    //hien thi trang chu
    public function home(){
        $products = Product::query()
        ->latest('id')
        ->where('is_active',1)
        ->with('category', 'variants.color')
        ->limit(4)
        ->get();
       $productView=Product::query()
       ->latest('view')
       ->where('is_active',1)
        ->with('category', 'variants.color')
        ->limit(4)
        ->get();
        $banners=Banner::query()
        ->where('is_active',1)
        ->get();
        
        return view('client.home',compact('products','productView','banners'));
     

    }
    //chi tiet san pham
    

    public function getProductVariantPrice(Request $request)
    {
        $product = Product::find($request->product_id);
    
        if ($product) {
            $productVariant = $product->variants->where('size_id', $request->size)
                                                ->where('color_id', $request->color)
                                                ->first();
    
            if ($productVariant) {
                $price_sale = $productVariant->price_sale;
                $price =$productVariant->price;
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
    //tim kiem san pham
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
                $products = Product::query()
            ->where('name', 'LIKE', "%{$keyword}%")
            ->with('category', 'variants.color')
            ->paginate(8);
        
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
    
        return view('client.show.shop', compact('products', 'categories', 'totalproducts', 'allColors'))
               ->with('keyword', $keyword); 
    }
        
      


}
