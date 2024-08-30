<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // function index(){
    //     $products = Product::query()->latest('id')->with('category','variants.color')->limit(30)->get();
    //     $categories = Category::withCount('products')->get();
    //  // Lấy tất cả các màu sắc của các biến thể, loại bỏ màu trùng lặp
    // $allColors = $products->flatMap(function ($product) {
    //     return $product->variants->pluck('color')->filter()->unique('hex_code');
    // });
        
    //     $totalproducts = $categories->sum('products_count');
    //     // dd($totalproducts);
        
    //     return view('client.show.shop',compact('products','categories','totalproducts','allColors'));
    // }
    public function index(Request $request, $id = null)
    {
        // Xử lý trường hợp lọc theo danh mục
        if ($id) {
            $products = Product::query()
                ->where('category_id', $id)
                ->with('category', 'variants.color')
                ->latest('id')
                ->limit(30)
                ->get();
        } else {
            // Hiển thị tất cả sản phẩm
            $products = Product::query()
                ->latest('id')
                ->with('category', 'variants.color')
                ->limit(30)
                ->get();
        }
    
        // Lấy tất cả các danh mục
        $categories = Category::query()->withCount('products')->get();
    
        // Lấy tất cả các màu sắc của các biến thể, loại bỏ màu trùng lặp
        $allColors = $products->flatMap(function ($product) {
            return $product->variants->pluck('color')->filter()->unique('hex_code');
        });
    
        // Tính tổng số sản phẩm
        $totalproducts = $categories->sum('products_count');
    
        // Truyền dữ liệu đến view
        return view('client.show.shop', compact('products', 'categories', 'totalproducts', 'allColors'));
    }
    

   
    
    public function detail($slug) {
        $product = Product::query()->where('slug', $slug)
            ->with(['variants', 'category', 'galleries'])->first();
    
        $productVariants = $product->variants->all();
        $colorIds = [];
        $sizeIds = [];
    
        foreach ($productVariants as $item) {
            $colorIds[] = $item->color_id;
            $sizeIds[] = $item->size_id;
        }
    
        // Lấy mã màu từ bảng Color
        $colors = Color::query()->whereIn('id', $colorIds)
            ->pluck('hex_code', 'id')->all();
    
        $sizes = Size::query()->whereIn('id', $sizeIds)
            ->pluck('name', 'id')->all();
            // $sanpham_cung_loai = DB::table('sanphams')->where('id_danh_muc', $data->id_danh_muc)
            // ->where('id', '!=', $id)
            // ->get();
            $sanpham_cung_loai=Product::query()->where('id','!=',$product->id)->where('category_id',$product->category->id) ->distinct()->get();
            // dd($sanpham_cung_loai);
        return view('client.show.product_detail', compact('product', 'colors', 'sizes','sanpham_cung_loai'));
    }
    
}
