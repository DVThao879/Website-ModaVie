@extends('client.layouts.app')
@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Tài khoản của tôi</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ</a>
                    </li>
                    <li class="active">Tài khoản của tôi</li>
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
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i>Đơn Hàng</a>
                                    <a href="#account-info" class="active" data-bs-toggle="tab"><i
                                            class="fa fa-user"></i>Thông Tin Cá
                                        Nhân</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-user"></i>Sản Phẩm Yêu Thích</a>
                                </div>
                            </div>
                        
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
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
                                                        @foreach ($bills as $key => $item)
                                                            <tr> <!-- Add this opening <tr> tag to start each row -->
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                                                <td>
                                                                    @if($item->status == 1)
                                                                        Chờ xác nhận
                                                                    @elseif($item->status == 2)
                                                                        Chờ lấy hàng
                                                                    @elseif($item->status == 3)
                                                                        Đang giao hàng
                                                                    @elseif($item->status == 4)
                                                                        Giao thành công
                                                                    @elseif($item->status == 5)
                                                                        Chờ hủy
                                                                    @elseif($item->status == 6)
                                                                        Đã hủy
                                                                    @else
                                                                        Không xác định
                                                                    @endif
                                                                </td>
                                                                <td>{{ number_format($item->total, 0, ',', '.') }} VND</td>
                                                                <td><a href="{{ route('viewBillDetail', $item->id) }}">Xem</a>
                                                                    @if($item->status == 1)
                                                                    | <a href="{{ route('cancelOrder', $item->id) }}" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">Hủy</a>
                                                                @endif</td>

                                                            </tr> <!-- Add this closing </tr> tag to end each row -->
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
                                                    <form action="{{ route('updateMyAcount', ['id' => Auth::user()->id]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
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
                                  
                                </div>

                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    
@endsection
