@extends('client.layouts.app')

@section('content')
<div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url(assets/images/bg/breadcrumb.jpg);">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <div class="breadcrumb-title">
                <h2>My account page</h2>
            </div>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">My account </li>
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
                                <!-- Single Tab Content Start -->

                                {{-- <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Dashboard</h3>
                                       
                                        <div class="welcome">
                                           
                                        
                                           
                                            <p>Hello, <strong>{{Auth::user()->name}}</strong></p>
                                        </div>

                                        <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                                    </div>
                                </div> --}}
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Sản phẩm đã mua</h3>
                                        {{-- @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif --}}
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Ngày Mua</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Tổng tiền</th>
                                                        <th>Hành Động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
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
                                                    action="{{ route('user.updateMyAcount', ['id' => Auth::user()->id]) }}"
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
