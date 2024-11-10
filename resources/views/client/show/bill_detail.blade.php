@extends('client.layouts.app')

@section('content')
    
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Chi tiết</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ</a>
                    </li>
                    <li class="active">Chi tiết đơn hàng </li>
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
                                   
                                    <a href="#orders" class="active" data-bs-toggle="tab"><i
                                            class="fa fa-cart-arrow-down"></i>Đơn Hàng</a>
                                  
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
                                                        @if($bill->productVariant)
                                                            <tr>

                                                                <td>{{$key+1}}</td>
                                                                <td>{{ $bill->productVariant->product->name }}</td>
                                                                <td>
                                                                    <a href=""><img width="50"
                                                                            src="{{ Storage::url($bill->productVariant->product->img_thumb) }}"
                                                                            alt=""></a>
                                                                </td>
                                                                <td>{{$bill->productVariant->size->name }},{{$bill->productVariant->color->name }}</td>
                                                                <td>{{ $bill->quantity }}</td>
                                                                <td>{{ $bill->price}}</td>
                                                               
                                                                </td>
                                                            </tr>
                                                            @else
                                                            <tr>

                                                                <td>{{$key+1}}</td>
                                                                <td>{{ $bill->product_name }}</td>
                                                                <td>
                                                                    <a href=""><img width="50"
                                                                            src=""
                                                                            alt="{{$bill->product_name }}"></a>
                                                                </td>
                                                                <td>{{$bill->size}},{{$bill->color}}</td>
                                                                <td>{{ $bill->quantity }}</td>
                                                                <td>{{ $bill->price }}</td>
                                                               
                                                                </td>
                                                            </tr>
                                                            @endif
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
