<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class CartController extends Controller
{
    public function addToCart(Request $request)
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
        return redirect()->route('cart.show')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
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


    public function updateCart(Request $request){
    $key = $request->input('key');
    $newQuantity = $request->input('quantity');
    $cart = session()->get('cart', []);

    // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
    if (isset($cart[$key])) {
        // Cập nhật số lượng sản phẩm
        $cart[$key]['quantity'] = $newQuantity;

        // Tính lại tổng tiền cho sản phẩm
        $subtotal = $cart[$key]['price_sale'] * $newQuantity;

        // Cập nhật lại giỏ hàng trong session
        session()->put('cart', $cart);

        // Tính tổng tiền của tất cả sản phẩm trong giỏ hàng
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
        // Logic xóa sản phẩm khỏi giỏ hàng
        $cart = session()->get('cart');
        $key = $request->input('key');
        if (isset($cart[$key])) {
            unset($cart[$key]);
        }
    
        // Cập nhật lại giỏ hàng trong session
        session()->put('cart', $cart);
    
        // Tính lại tổng tiền và kiểm tra xem giỏ hàng có trống không
        $total = 0;
        $cartItems = session()->get('cart', []);
        foreach ($cartItems as $item) {
            $total += $item['price_sale'] * $item['quantity'];
        }
    
        // Trả về phản hồi
        return response()->json([
            'success' => true,
            'total' => number_format($total, 0, ',', '.'),
            'isEmpty' => empty($cartItems) // Trả về thông tin giỏ hàng có trống không
        ]);
    }
    
    // Xóa tất cả sản phẩm trong giỏ hàng
    public function clearAllCart(Request $request)
    {
        session()->forget('cart'); 
    
            return redirect()->route('cart.show')->with('success', 'Giỏ hàng đã được xóa.');
    }
    
    
    
    public function showCheckout()
    {
        $cart = session()->get('cart', []);
        // dd($cart);
        $total = 0;
        $errors = [];
   

        foreach ($cart as $key => $item) {
            $variant = ProductVariant::find($item['variant_id']);
            
            // Kiểm tra nếu biến thể không tồn tại hoặc số lượng yêu cầu lớn hơn số lượng trong kho
            if (!$variant || $item['quantity'] > $variant->quantity) {
                $stockQuantity = $variant ? $variant->quantity : 0;
                $errors[] = 'Sản phẩm ' . $item['name'] . ' 
                             Chỉ còn ' . $stockQuantity . ' sản phẩm.';
            } else {
                // Tính tổng tiền nếu sản phẩm đủ điều kiện
                $total += $item['price_sale'] * $item['quantity'];
                session()->put('cart_total', $total);

            }
            
            
        }
    
        // Nếu có lỗi, chuyển hướng về trang giỏ hàng với thông báo lỗi
        if (!empty($errors)) {
            // Truyền thông báo lỗi vào session với phương thức with()
            return redirect()->route('cart.show')->with('error', $errors);
        }
    
        // Nếu không có lỗi, tiếp tục hiển thị trang checkout
        return view('client.show.checkout', compact('cart', 'total'));
    }
    public function applyVoucher(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, fn($sum, $item) => $sum + $item['price_sale'] * $item['quantity'], 0);
    
    
        session()->put('cart_total', $total);
    
        $voucher = Voucher::where('code', $request->input('code'))
                          ->where('start_date', '<=', Carbon::now())
                          ->where('end_date', '>=', Carbon::now())
                          ->where('is_active', true)
                          ->where('quantity', '>', 0)
                          ->first();
    
       
    
        if (!$voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }
        if (session()->has('voucher_id') && session()->get('voucher_id') == $voucher->id) {
            return redirect()->back()->with('error', 'Bạn đã áp dụng mã giảm giá này trước đó.');
        }
        if (Auth::check()) {
            $userId = Auth::id();
            $usedVoucher = DB::table('bills')
                ->where('user_id', $userId)
                ->where('voucher_id', $voucher->id)
                ->exists();
    
           
    
            if ($usedVoucher) {
                return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi.');
            }
        }
    
        if ($total < $voucher->min_money || $total > $voucher->max_money) {
            return redirect()->back()->with('error', 'Giá trị đơn hàng không đủ điều kiện.');
        }
        
        $discount = $voucher->discount;
        $totalAfterDiscount = $total - ($total * ($discount / 100));
    
    
        session()->put('discount', $discount);
        session()->put('total_after_discount', $totalAfterDiscount);
        session()->put('voucher_id', $voucher->id);
    
        return redirect()->back()->with('success', 'Mã giảm giá đã được áp dụng!');
    }
    
    
    public function placeOrder(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0\d{9}$/',
            'pttt' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Tên không được để trống.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'address.required' => 'Địa chỉ không được để trống.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'pttt.required' => 'Vui lòng chọn phương thức thanh toán.',
            'notes.max' => 'Ghi chú không được vượt quá 500 ký tự.',
        ]);
    
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Bạn chưa có sản phẩm nào, vui lòng quay lại');
        }
    
        $total = session()->get('cart_total', 0);
      
        $discount = session()->get('discount', 0);
        $totalAfterDiscount = session()->get('total_after_discount', $total);
        $voucherId = session()->get('voucher_id');
        $paymentMethod = $request->input('pttt');
    
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $is_guest= Auth::check()? 1 : 0;
        $user_name = $request->input('name', $user->name ?? '');
        $user_email = $request->input('email', $user->email ?? '');
        $user_address = $request->input('address', $user->address ?? '');
        $user_phone = $request->input('phone', $user->phone ?? '');
        $billId = DB::table('bills')->insertGetId([
            'user_id' => $userId,
            'is_guest'=> $is_guest,
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'total' => $totalAfterDiscount,
            'created_at' => Carbon::now(),
            'note' => $request->input('notes'),
            'status' => '1',
            'payment_method' => $paymentMethod,
            'order_code' => 'MODAVIE' . strtoupper(Str::random(10)),
            'voucher_id' => $voucherId, 
        ]);
    
        foreach ($cart as $item) {
            $variantId = $item['variant_id'];
            $variant = DB::table('product_variants')->where('id', $variantId)->first();
    
            if (!$variant || $variant->quantity < $item['quantity']) {
                return redirect()->route('cart.show')->with('error', 'Sản phẩm ' . $item['name'] . ' không đủ số lượng trong kho.');
            }
    
            DB::table('bill_details')->insert([
                'bill_id' => $billId,
                'product_variant_id' => $variantId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price_sale'],
                'size' => DB::table('sizes')->where('id', $variant->size_id)->value('name'),
                'color' => DB::table('colors')->where('id', $variant->color_id)->value('name'),
            ]);
    
            DB::table('product_variants')->where('id', $variantId)->decrement('quantity', $item['quantity']);
        }
    
        if ($voucherId) {
            DB::table('vouchers')->where('id', $voucherId)->decrement('quantity', 1);
        }
    
        $order = DB::table('bills')->where('id', $billId)->first();
        Mail::to($user_email)->send(new OrderInvoiceMail($order, $cart, $discount));
    
        session()->forget(['cart', 'discount', 'total_after_discount', 'voucher_id']);
    
        return redirect()->route('cart.show')->with('success', 'Đặt hàng thành công. Vui lòng thanh toán khi nhận hàng.');
    }
    
    
    

    
    


    public function searchBill(Request $request)
    {
        $orderCode = $request->input('order_code');   
        $bills = Bill::query()->where('order_code', $orderCode)->get();
        if ($bills->isEmpty()) {
            return view('client.show.order_tracking', ['message' => 'Không tìm thấy đơn hàng nào với mã đơn hàng này.']);
        }
        $billIds = $bills->pluck('id');
        $billDetails = BillDetail::whereIn('bill_id', $billIds)->with(['product', 'productVariant'])->get();
        // dd($billDetails);
        return view('client.show.order_tracking', compact('bills', 'billDetails'));
    }
}
