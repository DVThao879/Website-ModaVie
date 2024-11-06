@component('mail::message')
# Hóa Đơn Đặt Hàng

Cảm ơn bạn đã mua hàng!

**Mã đơn hàng:** {{ $order->order_code}}  
**Tổng cộng:** {{ $order->total }}  
@if ($discount > 0)
**Giảm giá đã áp dụng:** {{ $discount }}%
@endif

## Chi Tiết Đơn Hàng

@foreach ($cart as $item)
@if(isset($item['name']))
- **Sản phẩm:** <a href="{{ route('product.detail', Str::slug($item['name'])) }}"> {{ $item['name'] }}</a>
@endif
{{-- - **Ảnh:** <br>
@if(isset($item['img_thumb']))
    <img src="{{ asset('storage/' . $item['img_thumb']) }}" alt="{{ $item['name'] }}" style="max-width: 200px; height: auto;">
@endif --}}
- **Số lượng:** {{ $item['quantity'] }}
- **Giá:** {{ number_format($item['price_sale'], 0, ',', '.') }} VNĐ
- **Kích cỡ:** {{ $item['size'] }}
- **Màu sắc:** {{ $item['color'] }}

@endforeach

Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
