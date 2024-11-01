<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;
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
                'image' => $product->img_thumb,
                'variant_id' => $variant->id
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

public function showCheckout(){
    $cart = session()->get('cart', []);
// dd($cart);
    $totalAmount = 0;


    foreach ($cart as $item) {
        $totalAmount += $item['price_sale'] * $item['quantity'];
    }

    return view('client.show.checkout', compact('cart', 'totalAmount'));

}
public function placeOrder(Request $request)
{
    // Lấy giỏ hàng từ session
    $paymentMethod = $request->input('pttt');
    if (empty($paymentMethod)) {
        return redirect()->route('user.checkout')->with('error', 'Vui lòng chọn phương thức thanh toán.');
    }
    $cart = session()->get('cart', []);
    $total = 0;
    $discount = 0;
    if(!$cart){
        return redirect()->route('user.checkout')->with('error', 'Bạn chưa có sản phẩm nào,vui lòng quay lại');
    }
    // if (session()->has('coupon')) {
    //     $discount = session()->get('coupon')['discount'];
    // }
    foreach ($cart as $item) {
        $total += $item['price_sale'] * $item['quantity'];
    }

    // Tính tổng sau khi giảm giá
    // if ($discount) {
    //     $total = $total - ($total * ($discount / 100));
    // }

    if (Auth::check()) {
        $user = Auth::user();
        $id = $user->id;
        $user_name = $user->name ?? $request->email;
        $user_email = $user->email ?? $request->email;
        $user_address = $user->address ?? $request->address;
        $user_phone = $user->phone ?? $request->phone;
    } else {
        $id = null;
        $user_name = $request->name;
        $user_email = $request->email;
        $user_address = $request->address;
        $user_phone = $request->phone;
    }

    // Tạo đơn hàng mới và nhận lại ID của hóa đơn vừa chèn
    $billId = DB::table('bills')->insertGetId(values: [
        'user_id' => $id,
        'user_name' => $user_name,
        'user_email' => $user_email,
        'user_address' => $user_address,
        'user_phone' => $user_phone,
        'total' => $total,
        'date' => Carbon::now()->format('Y-m-d H:i:s'),
        'note' => $request->input('notes'),
        'status'=>'Chờ xác nhận',
        'payment_method' => $paymentMethod,
        'order_code' => 'MODAVIE' . strtoupper(Str::random(10)),
    ]);
  // Lưu chi tiết đơn hàng
  foreach ($cart as $key => $item) {
    // Tách key để lấy thông tin product_id và biến thể
    list($productId, $sizeId, $colorId) = explode('-', $key);
    $product = DB::table('products')->where('id', $productId)->first();
    $productImage = $product->img_thumb;
    $size = DB::table('sizes')->where('id', $sizeId)->value('name');
    $color = DB::table('colors')->where('id', $colorId)->value('name');
    
    $currentStock = DB::table('product_variants')->where('id', $item['variant_id'])->value('quantity');
    
    if ($currentStock < $item['quantity']) {
        return redirect()->route('user.checkout')->with('error', 'Sản phẩm ' . $item['name'] . ' không đủ số lượng trong kho.');
    }
    // Cập nhật thông tin sản phẩm trong giỏ hàng
    $item['img_thumb'] = $productImage;
    $item['size'] = $size;
    $item['color'] = $color;
    DB::table('bill_details')->insert([
        'bill_id' => $billId, 
        'product_id' => $productId, 
        'product_variant_id' => $item['variant_id'], 
        'quantity' => $item['quantity'], 
        'price_sale' => $item['price_sale'],
        'color'=>$colorId, 
        'size'=>$sizeId

    ]);

    // Giảm số lượng sản phẩm trong kho
    DB::table('product_variants')->where('id', $item['variant_id'])->decrement('quantity', $item['quantity']);
}
    $order = DB::table('bills')->where('id', $billId)->first();
Mail::to($user_email)->send(new OrderInvoiceMail($order, $cart, $discount));

Session::forget('cart');

return redirect()->route('user.cart.show')->with('success', 'Đặt hàng thành công. Vui lòng thanh toán khi nhận hàng.');
   

}



public function searchBill(Request $request){
    $orderCode = $request->input('order_code');

    // $bills = Bill::with('billDetails')
    // ->where('order_code', 'like', '%' . $orderCode . '%')
    // ->get();    
    $bills = Bill::query()->where('order_code',$orderCode)->get();
        
      
    $billIds = $bills->pluck('id');
    $billDetails = BillDetail::whereIn('bill_id', $billIds)->with(['product','productVariant'])->get();
    // dd($billDetails);
    return view('client.show.order_tracking',compact('bills','billDetails'));

}

   
}
