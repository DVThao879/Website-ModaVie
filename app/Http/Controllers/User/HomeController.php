<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Blog;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
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
        // Lấy sản phẩm bán chạy nhất
        $bestSellingProducts = ProductVariant::query()
        ->select('product_variants.id', 'product_variants.product_id', 'product_variants.size_id', 'product_variants.color_id', 'product_variants.price', 'product_variants.price_sale', DB::raw('SUM(bill_details.quantity) as total_sales'))
        ->join('bill_details', 'product_variants.id', '=', 'bill_details.product_variant_id')
        ->with(['product', 'color', 'size']) 
        ->groupBy('product_variants.id', 'product_variants.product_id', 'product_variants.size_id', 'product_variants.color_id', 'product_variants.price', 'product_variants.price_sale') 
        ->orderByDesc('total_sales')
        ->limit(4)
        ->get();
        $articles=Blog::query()
        ->latest('id')
        ->where('is_active',1)
        ->with('user')
        ->limit(3)
        ->get();
    
    
    
        return view('client.home',compact('products','productView','banners','bestSellingProducts','articles'));
    }
        public function cancelOrder($id){
        $order = Bill::find($id);
    
       
        if ($order && $order->status == 1) { 
            $order->status = 5; 
            $order->save();
    
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        } else {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }
    }
}
