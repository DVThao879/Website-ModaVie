@extends('admin.layouts.master')

@section('title')
Chi tiết đơn hàng
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center">
<a href="{{route('admin.bill.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<a onclick="return confirm('Bạn có muốn in hóa đơn, đơn hàng này không?');" href="{{ route('admin.gerenate', $bill->order_code) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
    class="fas fa-download fa-sm text-white-50"></i> In hóa đơn</a>
</div>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết đơn hàng</h4>
        <div>
        @if ($bill->status != 6 && $bill->status !=4)
            <span>Cập nhật đơn hàng</span> 
            @if ($bill->status == 1)
                <a class="btn btn-success" href="{{ route('admin.bill.confirmBill', $bill->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xác nhận đơn hàng này không?');" title="Chờ lấy hàng">
                    <i class="fa fa-check"></i></a>
            @elseif($bill->status == 2)
                <a class="btn btn-info" href="{{ route('admin.bill.shipBill', $bill->id) }}" onclick="return confirm('Bạn có chắc chắn muốn giao đơn hàng này không?');" title="Đang giao hàng">
                    <i class="fa fa-truck"></i></a>
            @elseif($bill->status == 3)
                <a class="btn btn-success" href="{{ route('admin.bill.confirmShipping', $bill->id) }}" onclick="return confirm('Bạn có chắc chắn đơn hàng này đã được giao không?');" title="Giao hàng thành công">
                    <i class="fa fa-check-circle-o"></i></a>
            @elseif($bill->status == 5)
                <a class="btn btn-danger" href="{{ route('admin.bill.cancelBill', $bill->id) }}" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" title="Đã hủy">
                    <i class="fa fa-times-circle"></i></a>
            @endif
        @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-hash mr-2 text-primary"></i>
                        <strong>ID:</strong> <span class="ml-2">{{$bill->id}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-person mr-2 text-primary"></i>
                        <strong>Tên tài khoản:</strong> 
                        <span class="ml-2">
                            @if($bill->user_id)
                                {{$bill->user->name}}
                            @elseif($bill->user_id == null && $bill->is_guest == 0)
                                Khách vãng lai
                            @elseif($bill->user_id == null && $bill->is_guest == 1)
                                Tài khoản bị xóa
                            @endif
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope mr-2 text-primary"></i>
                        <strong>Email tài khoản:</strong> 
                        <span class="ml-2">
                        @if($bill->user_id)
                            {{$bill->user->email}}
                        @elseif($bill->user_id == null && $bill->is_guest == 0)
                            Khách vãng lai nên không có email
                        @elseif($bill->user_id == null && $bill->is_guest == 1)
                            Tài khoản bị xóa nên không có email
                        @endif
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-person-circle mr-2 text-primary"></i>
                        <strong>Tên người đặt:</strong> <span class="ml-2">{{$bill->user_name}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone mr-2 text-primary"></i>
                        <strong>Số điện thoại:</strong> <span class="ml-2">{{$bill->user_phone}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope-fill mr-2 text-primary"></i>
                        <strong>Email:</strong> <span class="ml-2">{{$bill->user_email}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-geo-alt mr-2 text-primary"></i>
                        <strong>Địa chỉ:</strong> <span class="ml-2">{{$bill->user_address}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-info-circle mr-2 text-primary"></i>
                        <strong>Trạng thái đơn hàng:</strong> 
                        @if ($bill->status == 1)
                            <span class="badge badge-warning ml-2">Chờ xác nhận</span>
                        @elseif($bill->status == 2)
                            <span class="badge badge-info ml-2">Chờ lấy hàng</span>
                        @elseif($bill->status == 3)
                            <span class="badge badge-primary ml-2">Đang giao hàng</span>
                        @elseif($bill->status == 4)
                            <span class="badge badge-success ml-2">Giao hàng thành công</span>
                        @elseif($bill->status == 5)
                            <span class="badge badge-secondary ml-2">Chờ hủy</span>
                        @elseif($bill->status == 6)
                            <span class="badge badge-danger ml-2">Đã hủy</span>
                        @endif
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-sticky mr-2 text-primary"></i>
                        <strong>Ghi chú:</strong> 
                        <span class="ml-2">
                        @if($bill->note)
                        {{$bill->note}}
                        @else
                        Không có ghi chú!
                        @endif
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-calendar-check mr-2 text-primary"></i>
                        <strong>Ngày đặt:</strong> <span class="ml-2">{{$bill->created_at->format('d/m/Y H:i')}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-clock-history mr-2 text-primary"></i>
                        <strong>Ngày cập nhật:</strong> <span class="ml-2">{{$bill->updated_at->format('d/m/Y H:i')}}</span>
                    </li>
                </ul>                
            </div>
        </div>
    </div>
    <div class="card-footer">
        <h4 class="mb-3">Thông tin sản phẩm</h4>
            <!-- Bảng hiển thị biến thể -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh</th>
                        <th>Tên SP hiện tại</th>
                        <th>Tên SP lúc mua</th>
                        <th>Số lượng</th>
                        <th>Giá bán</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Tính tổng tiền
                        $totalPrice = $bill->billDetails->sum(function($billDetail) {
                            return $billDetail->quantity * $billDetail->price;
                        });
                    @endphp
                    @foreach ($bill->billDetails as $billDetail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($billDetail->product_variant_id)
                                <img width="100"
                                    src="{{ Storage::url($billDetail->productVariant->product->img_thumb) }}"
                                    alt="">
                                @else
                                <span>Không tìm thấy ảnh</span>
                                @endif
                            </td>
                            <td>
                                @if($billDetail->product_variant_id)
                                {{ $billDetail->productVariant->product->name }}
                                @else
                                Sản phẩm hiện tại đã bị xóa
                                @endif
                            </td>
                            <td>{{ $billDetail->product_name }}</td>
                            <td>{{ $billDetail->quantity }}</td>
                            <td>{{ number_format($billDetail->price, 0, ',', '.') }} VND</td>
                            <td>{{ $billDetail->size }}</td>
                            <td>{{ $billDetail->color }}</td>
                            <td>{{ number_format($billDetail->quantity * $billDetail->price, 0, ',', '.') }} VND</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">Tổng tiền:</td>
                        <td colspan="3">{{ number_format($totalPrice, 0, ',', '.') }} VND</td>
                    </tr>
                    <tr>
                        <td colspan="6">Mã giảm giá:</td>
                        <td colspan="3">
                            @if ($bill->voucher_id)
                                {{ $bill->voucher->code }} (-{{ $bill->voucher->discount }}%)
                            @else
                                Không có mã giảm giá
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">Tổng tiền cuối cùng:</td>
                        <td colspan="3">{{ number_format($bill->total, 0, ',', '.') }} VND</td>
                    </tr>
                </tbody>
            </table>
    </div>
</div>
@endsection
