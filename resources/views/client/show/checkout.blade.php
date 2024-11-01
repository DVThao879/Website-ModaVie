@extends('client.layouts.app')

@section('content')

<!-- search start -->
<div class="search-content-wrap main-search-active">
    <a class="search-close"><i class="la la-close"></i></a>
    <div class="search-content">
        <p>Start typing and press Enter to search</p>
        <form class="search-form" action="#">
            <input type="text" placeholder="Search entire store…">
            <button class="button-search"><i class="la la-search"></i></button>
        </form>
    </div>
</div>
<!-- mini cart start -->
<div class="sidebar-cart-active">
    <div class="sidebar-cart-all">
        <a class="cart-close" href="#"><i class="la la-close"></i></a>
        <div class="cart-content">
            <h3>Shopping Cart</h3>
            <ul>
                <li class="single-product-cart">
                    <div class="cart-img">
                        <a href="#"><img src="{{asset('theme/client/assets/images/cart/cart-1.jpg')}}" alt=""></a>
                    </div>
                    <div class="cart-title">
                        <h4><a href="#"> Flower Dress </a></h4>
                        <span>1 × £54.00</span>
                    </div>
                    <div class="cart-delete">
                        <a href="#">×</a>
                    </div>
                </li>
                <li class="single-product-cart">
                    <div class="cart-img">
                        <a href="#"><img src="{{asset('theme/client/assets/images/cart/cart-2.jpg')}}" alt=""></a>
                    </div>
                    <div class="cart-title">
                        <h4><a href="#">Ruffled cotton top</a></h4>
                        <span>1 × £54.00</span>
                    </div>
                    <div class="cart-delete">
                        <a href="#">×</a>
                    </div>
                </li>
            </ul>
            <div class="cart-total">
                <h4>Subtotal: <span>£ 108.00</span></h4>
            </div>
            <div class="cart-checkout-btn btn-hover default-btn">
                <a class="btn-size-md btn-bg-black btn-color" href="cart.html">view cart</a>
                <a class="no-mrg btn-size-md btn-bg-black btn-color" href="checkout.html">checkout</a>
            </div>
        </div>
    </div>
</div>
 <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url(assets/images/bg/breadcrumb.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <div class="breadcrumb-title">
                <h2>checkout page</h2>
            </div>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">checkout </li>
            </ul>
        </div>
    </div>
</div>
 <div class="checkout-main-area pt-100 pb-100">
    <div class="container">

        <div class="customer-zone mb-20">
            <p class="cart-page-title">Có phiếu giảm giá <a class="checkout-click3" href="#">Bấm vào đây để nhập mã của bạn</a></p>
            <div class="checkout-login-info3">
                <form action="" method="POST">
                    @csrf
                    <input type="text" name="code" placeholder="Mã giảm giá">
                    <input type="submit" value="Áp dụng">
                </form>
            </div>
        </div>
        <div class="checkout-wrap pt-30">
            <form action="{{route('user.placeOrder')}}" method="POST">
                @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="billing-info-wrap mr-50">

                        <h3>Thông Tin Người Nhận</h3>
                        <div class="row">
                            @if(Auth::check())
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Họ và tên: <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="name" value="{{Auth::user()->name}}">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="billing-info mb-20">
                                    <label>Email <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="email" value="{{Auth::user()->email}}">
                                </div>
                            </div>
                         
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Địa Chỉ <abbr class="required" title="required">*</abbr></label>
                                    <input class="billing-address" name="address" placeholder="" type="text"value="{{Auth::user()->address}}" >
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Điện Thoại <abbr class="required" title="required">*</abbr></label>
                                    <input class="billing-address" placeholder="Phone" type="text" name="phone"value="{{Auth::user()->phone}}" >
                                </div>
                            </div>
                            @else
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Họ và tên: <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="name" value="">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="billing-info mb-20">
                                    <label>Email <abbr class="required" title="required">*</abbr></label>
                                    <input type="text" name="email" value="">
                                </div>
                            </div>
                         
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Địa Chỉ <abbr class="required" title="required">*</abbr></label>
                                    <input class="billing-address" name="address" placeholder="" type="text"value="" >
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="billing-info mb-20">
                                    <label>Điện Thoại <abbr class="required" title="required">*</abbr></label>
                                    <input class="billing-address" placeholder="Phone" type="text" name="phone"value="" >
                                </div>
                            </div>

                            @endif
                        </div>
                       
                        <div class="additional-info-wrap">
                            <label>Ghi chú</label>
                            <textarea placeholder="Notes about your order, e.g. special notes for delivery. " name="note"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="your-order-area">
                        <h3>Đơn hàng của bạn</h3>
                        <div class="your-order-wrap gray-bg-4">
                            <div class="your-order-info-wrap">
                                <div class="your-order-info">
                                    <ul>
                                        <li>Sản Phẩm <span>Tổng Cộng</span></li>
                                    </ul>
                                </div>
                                @if(session('cart'))
                                    <div class="your-order-middle">
                                    <ul>
                                        @foreach($cart as $item)
                                        <li><a href="">{{$item['name']}}</a> <span>{{number_format($item['price_sale'] *$item['quantity'],0,',','.')}} VND </span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                {{-- @if(isset($coupon))
                                <div class="your-order-info order-subtotal">
                                    <ul>
                                        <li>Giảm Giá <span>{{($coupon['discount'])}} %</span></li>
                                    </ul>
                                </div>
                              @endif --}}
                               
                                <div class="your-order-info order-subtotal">
                                    <ul>
                                        <li>Tổng Tiền <span>{{ number_format($totalAmount, 0, ',', '.') }} VND </span></li>
                                    </ul>
                                </div>
                               
                                {{-- @else
                                <p>Khong có</p>
                                @endif --}}


                   
                                
                            
                            </div>
                            <div class="payment-method">
                                <!-- Thanh toán khi nhận hàng (COD) -->
                                <div class="pay-top sin-payment">
                                    <input id="payment-method-3" class="input-radio" type="radio" value="cod" name="pttt">
                                    <label for="payment-method-3">Thanh toán khi nhận hàng (COD)</label>
                                    <div class="payment-box payment_method_bacs">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>
                                    </div>
                                </div>
                            
                                <!-- Thanh toán qua Momo bằng thẻ ATM nội địa -->
                                <div class="pay-top sin-payment sin-payment-3">
                                    <input id="payment-method-4" class="input-radio" type="radio" value="momo" name="pttt">
                                    <label for="payment-method-4">Thanh toán qua Momo (thẻ ATM nội địa)</label>
                                    <div class="payment-box payment_method_bacs">
                                        <p><img alt="" src="{{asset('theme/user/assets/images/icon-img/payment.png')}}"> Sử dụng thẻ ATM nội địa để thanh toán qua Momo.</p>
                                    </div>
                                </div>
                            </div>
                           

                            
                            
                        </div>
                        {{-- <div class="Place-order mt-40">
                            <a href="#">Đặt Hàng</a>
                        </div> --}}
                        <div class="cart-shiping-update-wrapper">
                            <div class="cart-clear">
                                <button type="submit" class="btn-size-md btn-bg-black btn-color" >Đặt Hàng</button>
                            </div>
                        </div>
                        {{-- <script type="text/javascript">
                            function handlePayment() {
                                var paymentMethod = document.querySelector('input[name="pttt"]:checked').value;
                                
                                if (paymentMethod === 'momo') {
                                    // Chuyển đến xử lý thanh toán qua Momo (ATM nội địa)
                                    document.forms[0].action = '{{ route('momo.paymentATM', ['billId' => $bill->id, 'total' => $bill->total]) }}';
                                } else {
                                    // Thanh toán COD
                                    document.forms[0].action = '{{ route('user.placeOrder') }}';
                                }
                                
                                document.forms[0].submit();
                            }
                        </script>
                         --}}
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
 @endsection