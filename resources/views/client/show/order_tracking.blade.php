@extends('client.layouts.app')
@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url(assets/images/bg/breadcrumb.jpg);">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>My account page</h2>
                </div>
                <ul>
                    <li><a href="index.html">Home</a></li>
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
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <form action="{{ route('bill.search') }}" method="GET" style="display: flex; align-items: center;">
                                        <input type="text" name="order_code" placeholder="Nhập mã đơn hàng" 
                                               style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-right: 10px;">
                                        <button type="submit" style="display: none"></button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3>Kết quả tìm kiếm</h3>

                                            @foreach($bills as $key=>$bill)
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- Cột bên trái: Thông tin người đặt -->
                                                            <div class="col-md-6">
                                                                <h5 class="card-title">Thông tin người đặt hàng</h5>
                                                                <p class="card-text">
                                                                    <strong>Tên: </strong> {{ $bill->user_name }}<br>
                                                                    <strong>Số điện thoại: </strong> {{ $bill->user_phone }}<br>
                                                                    <strong>Địa chỉ: </strong> {{ $bill->user_address }}<br>
                                                                    <strong>Ngày mua: </strong> {{ \Carbon\Carbon::parse($bill->date)->format('d-m-Y') }}<br>
                                                                    <strong>Thanh toán: </strong> @if($bill->payment_method=='cod')
                                                                                                            Thanh toán khi nhận hàng
                                                                                                @else
                                                                                                            Đã thanh toán thành công
                                                                                                @endif
                                                                    <br>
                                                                    <strong>Trạng thái: </strong> {{ $bill->status }}<br>
                                                                    <strong>Tổng tiền: </strong> {{ number_format($bill->total, 0, ',', '.') }} VND<br>
                                                                </p>
                                                            </div>

                                                            <!-- Cột bên phải: Chi tiết đơn hàng -->
                                                            <div class="col-md-6">
                                                                <h5 class="card-title">Chi tiết đơn hàng</h5>
                                                                <ul class="list-group">
                                                                    @foreach($billDetails as $detail)
                                                                        <li class="list-group-item">
                                                                            <strong>Sản phẩm: </strong> {{ $detail->product->name }}<br>
                                                                            <strong>Ảnh: </strong><img width="50px" src="{{Storage::url($detail->product->img_thumb)}}" alt=""><br>
                                                                            <strong>Số lượng: </strong> {{ $detail->quantity }}<br>
                                                                            <strong>Giá: </strong> {{ number_format($detail->price_sale, 0, ',', '.') }} VND<br>
                                                                            <strong>Size: </strong> {{ $detail->productVariant->size->name }}<br>
                                                                            <strong>Màu: </strong> {{ $detail->productVariant->color->name }}

                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
@endsection
