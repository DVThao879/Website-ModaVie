<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;

class CartController extends Controller
{public function addToCart(Request $request)
    {
        // Kiểm tra dữ liệu form gửi lên
        $productId = $request->input('product_id');
        $sizeId = $request->input('size');
        $colorId = $request->input('color');
        $quantity = $request->input('quantity');
    
        // Tạo key duy nhất cho sản phẩm với biến thể
        $key = $productId . '-' . $sizeId . '-' . $colorId;
    
        // Lấy sản phẩm và biến thể từ cơ sở dữ liệu
        $product = Product::find($productId);
        $variant = ProductVariant::where('product_id', $productId)
                                  ->where('size_id', $sizeId)
                                  ->where('color_id', $colorId)
                                  ->first();
    
        if (!$product || !$variant) {
            return redirect()->back()->with('error', 'Sản phẩm, kích thước hoặc màu sắc không hợp lệ.');
        }
    
        // Kiểm tra số lượng sản phẩm trong kho
        if ($quantity > $variant->quantity) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm yêu cầu vượt quá số lượng trong kho.');
        }
    
        // Tạo giỏ hàng từ session
        $cart = session()->get('cart', []);
    
        if (isset($cart[$key])) {
            $newQuantity = $cart[$key]['quantity'] + $quantity;
    
            if ($newQuantity > $variant->quantity) {
                return redirect()->back()->with('error', 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng có sẵn.');
            }
    
            $cart[$key]['quantity'] = $newQuantity;
        } else {
            $cart[$key] = [
                'name' => $product->name,
                'size' => $variant->size->name, 
                'color' => $variant->color->name, 
                'price_sale' => $variant->price_sale, 
                'quantity' => $quantity,
                'image' => $product->img_thumb
            ];
        }
    
        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);
    
        // Chuyển hướng đến trang giỏ hàng
        return redirect()->route('user.cart.show')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
    

    public function showCart()
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
    
        // Khởi tạo tổng tiền ban đầu
        $totalAmount = 0;
    
        // Sử dụng foreach để tính tổng tiền
        foreach ($cart as $item) {
            $totalAmount += $item['price_sale'] * $item['quantity'];
        }
    
        // Trả về view và truyền biến $cart và $totalAmount
        return view('client.show.cart', compact('cart', 'totalAmount'));
    }
    

    public function updateCart(Request $request)
    {
        $key = $request->input('key');
        $newQuantity = $request->input('quantity');
        $cart = session()->get('cart', []);
    
        if (isset($cart[$key])) {
            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $cart[$key]['quantity'] = $newQuantity;
    
            // Tính lại tổng tiền cho sản phẩm
            $subtotal = $cart[$key]['price_sale'] * $newQuantity;
    
            // Cập nhật lại giỏ hàng trong session
            session()->put('cart', $cart);
    
            // Tính lại tổng tiền của tất cả sản phẩm trong giỏ hàng
            $total = array_sum(array_map(function ($item) {
                return $item['price_sale'] * $item['quantity'];
            }, $cart));
    
            // Trả về dữ liệu JSON cho AJAX
            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'total' => number_format($total, 0, ',', '.')
            ]);
        }
    
        return response()->json(['success' => false], 400);
    }
    

public function removeFromCart(Request $request)
{
    $key = $request->input('key');
    $cart = session()->get('cart', []);

    if (isset($cart[$key])) {
        unset($cart[$key]);
        session()->put('cart', $cart);

        // Tính lại tổng tiền sau khi xóa
        $total = array_sum(array_map(function ($item) {
            return $item['price_sale'] * $item['quantity'];
        }, $cart));

        return response()->json([
            'success' => true,
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    return response()->json(['success' => false], 400);
}

}
