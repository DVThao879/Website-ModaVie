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
                            <a href="#"><img src="{{ asset('theme/user/assets/images/cart/cart-1.jpg') }}"
                                    alt=""></a>
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
                            <a href="#"><img src="{{ asset('theme/user/assets/images/cart/cart-2.jpg') }}"
                                    alt=""></a>
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
                    <h2>my account page</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">my account </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="my-account-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    {{-- <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                    Dashboard</a> --}}
                                    <a href="#orders" class="active" data-bs-toggle="tab"><i
                                            class="fa fa-cart-arrow-down"></i>Đơn Hàng</a>
                                    {{-- <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a> --}}
                                    {{-- <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                    Method</a> --}}
                                    {{-- <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a> --}}
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i>Thông Tin Cá
                                        Nhân</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-user"></i>Sản Phẩm Yêu Thích</a>

                                    <a href="login-register.html"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <h3>Sản phẩm đã mua</h3>
                                                <a href="{{route('my_acount')}}"  style="text-decoration: none;">Quay lại</a>
                                            </div>
                                           
                                            
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Tên Sản Phẩm</th>
                                                            <th>Ảnh Sản Phẩm</th>
                                                            <th>Size,Color</th>
                                                            <th>Số Lượng </th>
                                                            <th>Giá</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      
                                                        @foreach ($billDetails as $key=>$bill)
                                                            <tr>

                                                                <td>{{$key+1}}</td>
                                                                <td>{{ $bill->product->name }}</td>
                                                                <td>
                                                                    <a href=""><img width="50"
                                                                            src="{{ Storage::url($bill->product->img_thumb) }}"
                                                                            alt=""></a>
                                                                </td>
                                                                <td>{{$bill->productVariant->size->name }},{{$bill->productVariant->color->name }}</td>
                                                                <td>{{ $bill->quantity }}</td>
                                                                <td>{{ $bill->price_sale }}</td>
                                                               
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Chi tiết tài khoản</h3>
                                            <div class="account-details-form">
                                                @if (Auth::check())
                                                    <form
                                                        action="{{ route('updateMyAcount', ['id' => Auth::user()->id]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="first-name" class="required">Tên</label>
                                                                    <input type="text" id="first-name" name="name"
                                                                        value="{{ Auth::user()->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="last-name" class="required">Email</label>
                                                                    <input type="text" id="last-name" name="email"
                                                                        value="{{ Auth::user()->email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="display-name" class="required">Địa chỉ</label>
                                                            <input type="text" id="display-name" name="address"
                                                                value="{{ Auth::user()->address }}">
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="email" class="required">Điện thoại</label>
                                                            <input type="text" id="email" name="phone"
                                                                value="{{ Auth::user()->phone }}">
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="email" class="required">Ảnh</label>
                                                            <input type="file" id="email" name="image">
                                                            <div class="text-center mb-3" style="margin-top: 20px">
                                                                <img width="100"
                                                                    src="{{ Storage::url(Auth::user()->image) }}"
                                                                    alt="">

                                                            </div>
                                                        </div>
                                                        {{-- <fieldset>
                                                    <legend>Password change</legend>
                                                    <div class="single-input-item">
                                                        <label for="current-pwd" class="required">Current Password</label>
                                                        <input type="password" id="current-pwd" />
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="new-pwd" class="required">New Password</label>
                                                                <input type="password" id="new-pwd" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="confirm-pwd" class="required">Confirm Password</label>
                                                                <input type="password" id="confirm-pwd" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset> --}}
                                                        <div class="single-input-item">
                                                            <button class="check-btn sqr-btn ">Save Changes</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                </div>

                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
@endsection
