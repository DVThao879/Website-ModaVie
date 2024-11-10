@extends('client.layouts.app')

@section('content')
 <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <div class="breadcrumb-title">
                <h2>Thanh toán</h2>
            </div>
            <ul>
                <li>
                    <a href="index.html">Trang chủ</a>
                </li>
                <li class="active">Thanh toán</li>
            </ul>
        </div>
    </div>
</div>
 <div class="checkout-main-area pt-100 pb-100">
    <div class="container">
        @if(Auth::check())
        <div class="customer-zone mb-20">
            <p class="cart-page-title">Có phiếu giảm giá <a class="checkout-click3" href="#">Bấm vào đây để nhập mã của bạn</a></p>
            <div class="checkout-login-info3">
                <form action="{{ route('apply.voucher') }}" method="POST">
                    @csrf
                    <input type="text" name="code" placeholder="Mã giảm giá" required>
                    <input type="submit" value="Áp dụng">
                </form>
            </div>
        </div>
        @endif
        <div class="checkout-wrap pt-30">
            <form action="{{route('placeOrder')}}" method="POST">
                @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap mr-50">

                        <h3>Thông Tin Người Nhận</h3>
                        <div class="row">
                            @if(Auth::check())
                           
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Họ và tên: <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="name" value="{{old('name',Auth::user()->name)}}">
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="billing-info mb-20">
                                    <label>Email <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="email" value="{{old('email',Auth::user()->email)}}">
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                         
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Địa Chỉ <abbr class="required" title="required">*</abbr></label>
                                    <input class="billing-address" name="address" placeholder="" type="text" value="{{old('address',Auth::user()->address)}}">
                                    @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Điện Thoại <abbr class="required" title="required">*</abbr></label>
                                    <input class="billing-address" placeholder="Phone" type="text" name="phone" value="{{old('phone',Auth::user()->phone)}}" >
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                            @else
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Họ và tên: <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="name" value="{{old('name')}}" >
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="billing-info mb-20">
                                    <label>Email <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="email" value="{{old('email')}}"  >
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                         
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Địa Chỉ <abbr class="required" title="required">*</abbr></label>
                                    <input  name="address" placeholder="" type="text" value="{{old('address')}}" >
                                    @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Điện Thoại <abbr class="required" title="required">*</abbr></label>
                                    <input  placeholder="Phone" type="text" name="phone" value="{{old('phone')}}">
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                     @enderror
                                </div>
                            </div> 

                             @endif
                        </div>
                       
                        <div class="additional-info-wrap">
                            <label>Ghi chú</label>
                            <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="note" >{{old('note')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="your-order-area">
                        <h3>Đơn hàng của bạn</h3>
                        <div class="your-order-wrap gray-bg-4" style="background-color: #f7f7f7; padding: 20px; border-radius: 8px;">
                            <div class="your-order-info-wrap">
                                <div class="your-order-info" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px;">
                                    <ul style="list-style: none; padding: 0; margin: 0; font-weight: bold; color: #333;">
                                        <li>Sản Phẩm <span style="float: right;">Tổng Cộng</span></li>
                                    </ul>
                                </div>
                        
                                @if(session('cart'))
                                <div class="your-order-middle" style="border-top: 1px solid #ddd; padding-top: 10px;">
                                    <ul style="list-style: none; padding: 0; margin: 0;">
                                        @foreach($cart as $item)
                                        <li style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #eee;">
                                            <div style="flex-grow: 1;">
                                                <a href="" style="font-weight: bold; color: #333; text-decoration: none; font-size: 14px;">{{ $item['name'] }}</a>
                                                <p style=" font-size: 12px; color: #666; margin: 3px 0 0;">{{ $item['color'] }}, {{ $item['size'] }} x {{ $item['quantity'] }}</p>
                                            </div>
                                            <span style="font-weight: bold; color: #333; font-size: 13px;">{{ number_format($item['price_sale'] * $item['quantity'], 0, ',', '.') }} VND</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @if(session('discount'))
                                <div class="your-order-info order-subtotal" style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                                    <ul style=" list-style: none; padding: 0; margin: 0; font-weight: bold; color: #333;">
                                        <li style="font-weight: bold;">Giảm Giá <span style="float: right;">{{ session('discount') }} %</span></li>
                                    </ul>
                                </div>
                                
                                @endif

                          
                            
                            @if(session('total_after_discount'))
                            <div class="your-order-info order-subtotal" style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                                <ul style=" list-style: none; padding: 0; margin: 0; font-weight: bold; color: #333;">
                                    <li style="font-weight: bold;">Tổng Tiền <span style="float: right;">{{ number_format( session('total_after_discount'), 0, ',', '.') }} VND</span></li>
                                </ul>
                            </div>
                            @else
                            <div class="your-order-info order-subtotal" style="border-top: 1px solid #ddd; padding-top: 15px; margin-top: 15px;">
                                <ul style=" list-style: none; padding: 0; margin: 0; font-weight: bold; color: #333;">
                                    <li style="font-weight: bold;">Tổng Tiền <span style="float: right;">{{ number_format($total, 0, ',', '.') }} VND</span></li>
                                </ul>
                            </div>
                            @endif
                               
                        
                                
                            </div>
                        
                           
                        
                            <div class="payment-method" style="margin-top: 20px;">
                                <!-- Thanh toán khi nhận hàng (COD) -->
                                <div class="pay-top sin-payment" style="margin-bottom: 10px;">
                                    <input id="payment-method-3" class="input-radio" type="radio" value="cod" name="pttt" style="margin-right: 5px;" @checked(old('pttt') == 'cod')>
                                    <label for="payment-method-3" style="font-weight: bold; cursor: pointer;">Thanh toán khi nhận hàng (COD)</label>
                                    <div class="payment-box payment_method_bacs" style="margin-left: 25px; font-size: 12px; color: #666; display: none;">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                                    </div>
                                </div>
                        
                                <!-- Thanh toán qua Momo bằng thẻ ATM nội địa -->
                                <div class="pay-top sin-payment sin-payment-3" style="margin-bottom: 10px;">
                                    <input id="payment-method-4" class="input-radio" type="radio" value="momo" name="pttt" style="margin-right: 5px;" @checked(old('pttt') == 'momo')>
                                    <label for="payment-method-4" style="font-weight: bold; cursor: pointer;">Thanh toán qua Momo (thẻ ATM nội địa)</label>
                                    <div class="payment-box payment_method_bacs" style="margin-left: 25px; font-size: 12px; color: #666; display: none;">
                                        <p><img alt="" src="{{ asset('theme/user/assets/images/icon-img/payment.png') }}" style="width: 20px; height: auto; vertical-align: middle; margin-right: 5px;"> Sử dụng thẻ ATM nội địa để thanh toán qua Momo.</p>
                                    </div>
                                </div>
                                @error('pttt')
                                <small class="text-danger">{{ $message }}</small>
                                 @enderror
                            </div>
                        </div>
                        
                       
                        <div class="cart-shiping-update-wrapper">
                            <div class="cart-clear">
                                <button type="submit" class="btn-size-md btn-bg-black btn-color" >Đặt Hàng</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
 @endsection