@extends('admin.layouts.master')

@section('title')
Thêm voucher
@endsection

@section('content')
<a href="{{route('admin.vouchers.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form action="{{route('admin.vouchers.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Main product information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin voucher</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="code" class="form-label">Mã voucher</label>
                            <input type="text" class="form-control" id="code" placeholder="Nhập mã voucher" name="code" value="{{ old('code') }}" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Giảm giá (%)</label>
                            <input type="number" class="form-control" id="discount" placeholder="Nhập % giảm giá" name="discount" value="{{ old('discount') }}" required>
                            @error('discount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="quantity" placeholder="Nhập số lượng" name="quantity" value="{{ old('quantity') }}" required>
                            @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="min_money" class="form-label">Số tiền tối thiểu</label>
                            <input type="number" class="form-control" id="min_money" placeholder="Nhập số tiền tối thiểu" name="min_money" value="{{ old('min_money') }}" required>
                            @error('min_money')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="max_money" class="form-label">Số tiền tối đa</label>
                            <input type="number" class="form-control" id="max_money" placeholder="Nhập số tiền tối đa" name="max_money" value="{{ old('max_money') }}" required>
                            @error('max_money')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!--                        Button -->
            <div class="d-flex justify-content-center mb-3">
                <button class="btn btn-success w-sm" type="submit">Thêm mới</button>
            </div>
        </div>
    </div>
</form>
@endsection