@extends('admin.layouts.master')

@section('title')
    Chi tiết voucher
@endsection

@section('content')
<a href="{{route('admin.vouchers.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết danh mục</h4>
        <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="btn btn-light btn-sm">Chỉnh sửa</a>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-info-circle-fill mr-2 text-primary"></i>
                <strong>ID:</strong> <span class="ml-2">{{$voucher->id}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-code-slash mr-2 text-primary"></i>
                <strong>Code:</strong> <span class="ml-2">{{$voucher->code}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-percent mr-2 text-primary"></i>
                <strong>Giảm giá:</strong> <span class="ml-2">{{$voucher->discount}}%</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-stack mr-2 text-primary"></i>
                <strong>Số lượng:</strong> <span class="ml-2">{{$voucher->quantity}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar-check mr-2 text-primary"></i>
                <strong>Ngày bắt đầu:</strong> <span class="ml-2">{{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar-x mr-2 text-primary"></i>
                <strong>Ngày kết thúc:</strong> <span class="ml-2">{{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-cash-stack mr-2 text-primary"></i>
                <strong>Giá tối thiểu:</strong> <span class="ml-2">{{number_format($voucher->min_money, 0, ',', '.')}} VND</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-cash-coin mr-2 text-primary"></i>
                <strong>Giá tối đa:</strong> <span class="ml-2">{{number_format($voucher->max_money, 0, ',', '.')}} VND</span>
            </li>            
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-check-circle mr-2 text-primary"></i>
                <strong>Trạng thái:</strong> <span class="ml-2">{!! $voucher->is_active ? '<span class="text-success mr-1">Hoạt động</span>' : '<span class="text-danger mr-1">Không hoạt động</span>' !!}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 mr-2 text-primary"></i>
                <strong>Ngày tạo:</strong> <span class="ml-2">{{$voucher->created_at->format('d/m/Y H:i')}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-pencil-square mr-2 text-primary"></i>
                <strong>Ngày sửa:</strong> <span class="ml-2">{{$voucher->updated_at->format('d/m/Y H:i')}}</span>
            </li>
        </ul>
    </div>
</div>
@endsection
