<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

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
        
        return view('client.home',compact('products','productView','banners'));
    }
}
