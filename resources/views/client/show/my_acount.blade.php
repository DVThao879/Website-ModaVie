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
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i>Đơn Hàng</a>
                                    {{-- <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i> Download</a> --}}
                                    {{-- <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                    Method</a> --}}
                                    {{-- <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i> address</a> --}}
                                    <a href="#account-info" class="active" data-bs-toggle="tab"><i
                                            class="fa fa-user"></i>Thông Tin Cá
                                        Nhân</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-user"></i>Sản Phẩm Yêu Thích</a>

                                    {{-- <a href="#reset-password" data-bs-toggle="tab"><i class="fa fa-sign-out"></i>Đổi mật
                                        khẩu</a> --}}
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
                                    <div class="tab-pane fade " id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Sản phẩm đã mua</h3>
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
                                                        @foreach($bills as $key=>$item)
                                                            <th>{{$key+1}}</th>
                                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}
                                                                <td>{{$item->status}}</td>
                                                                <td>{{ number_format($item->total, 0, ',', '.') }} VND</td>
                                                                <td><a href="{{route('viewBillDetail',$item->id)}}">Xem</a>
                                                                
                                                                </td>
                                                                @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                            

                                            
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show active" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Chi tiết tài khoản</h3>
                                            @if (session('success'))
                                                <script>
                                                    window.onload = function() {
                                                        alert("{{ session('success') }}");
                                                    }
                                                </script>
                                            @endif
                                            <div class="account-details-form">
                                                @if (Auth::check())
                                                    <form
                                                        action="{{ route('updateMyAcount', ['id' => Auth::user()->id]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="" class="required">Tên</label>
                                                                    <input type="text" name="name"
                                                                        value="{{ Auth::user()->name }}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="" class="required">Email</label>
                                                                    <input type="text" name="email"
                                                                        value="{{ Auth::user()->email }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="" class="required">Địa chỉ</label>
                                                            <input type="text" id="last-name" name="address"
                                                                value="{{ Auth::user()->address }}">
                                                        </div>
                                                        <div class="single-input-item">
                                                            <label for="" class="required">Điện thoại</label>
                                                            <input type="text" id="" name="phone"
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
                                                        <fieldset>
                                                            <div class="single-input-item">
                                                                <label for="current-pwd">Mật khẩu hiện tại</label>
                                                                <input type="password" id="current-pwd"
                                                                    name="current_password"
                                                                    value="{{ old('current_password') }}" />
                                                                @if ($errors->has('current_password'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('current_password') }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="new-pwd">Mật khẩu mới</label>
                                                                        <input type="password" id="new-pwd"
                                                                            name="new_password" />
                                                                        @if ($errors->has('new_password'))
                                                                            <span
                                                                                class="text-danger">{{ $errors->first('new_password') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="confirm-pwd">Nhập lại mật khẩu</label>
                                                                        <input type="password" id="confirm-pwd"
                                                                            name="new_password_confirmation" />
                                                                        @if ($errors->has('new_password_confirmation'))
                                                                            <span
                                                                                class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </fieldset>
                                                        <div class="single-input-item">
                                                            <button class="check-btn sqr-btn ">Save Changes</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                    {{-- <div class="tab-pane fade " id="reset-password" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Đổi mật khẩu</h3>
                                        @if (session('status'))
                                        <script>
                                            window.onload = function() {
                                                alert("{{ session('status') }}");
                                            }
                                        </script>
                                            @endif
                                            <div class="account-details-form">
                                                @if (Auth::check())
                                                    <form action="{{ route('user.updatePassword', ['id' => Auth::user()->id]) }}" method="post">
                                                        @csrf
                                                        <fieldset>
                                                            <div class="single-input-item">
                                                                <label for="current-pwd" class="required">Mật khẩu hiện tại</label>
                                                                <input type="password" id="current-pwd" name="current_password" required />
                                                                @if ($errors->has('current_password'))
                                                                <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="new-pwd" class="required">Mật khẩu mới</label>
                                                                        <input type="password" id="new-pwd" name="new_password" required />
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="single-input-item">
                                                                        <label for="confirm-pwd" class="required">Nhập lại mật khẩu</label>
                                                                        <input type="password" id="confirm-pwd" name="new_password_confirmation" required />
                                                                    </div>
                                                                </div>
                                                                @error('new_password')
                                                                <p class="text-danger">
                                                                    {{$message}}
                                                                </p>
                                                                @enderror
                                                            </div>
                                                        </fieldset>
                                                        <div class="single-input-item">
                                                            <button class="check-btn sqr-btn">Save Changes</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                            
                                    </div>
                                </div> --}}
                                </div>

                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
@endsection
