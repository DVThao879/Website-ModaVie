@extends('admin.layouts.master')

@section('title')
Sửa màu sắc
@endsection

@section('style-libs')
<!-- Plugins css -->
<link href="{{asset('theme/admin/libs/dropzone/dropzone.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('script-libs')
<!-- dropzone js -->
<script src="{{asset('theme/admin/libs/dropzone/dropzone-min.js')}}"></script>

<script src="{{asset('theme/admin/js/create-product.init.js')}}"></script>
@endsection

@section('content')
<a href="{{route('admin.colors.index')}}" class="btn btn-success mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form action="{{route('admin.colors.update', $color)}}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Main product information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin màu</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên màu</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập tên danh mục..." value="{{ old('name', $color->name) }}" name="name" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hex_code" class="form-label">Mã màu:</label>
                            <input type="text" class="form-control" id="hex_code" placeholder="#000000" name="hex_code" value="{{ old('hex_code', $color->hex_code) }}" required>
                            @error('hex_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!--                        Button -->
            <div class="d-flex justify-content-center mb-3">
                <button class="btn btn-success w-sm" type="submit">Cập nhật</button>
            </div>
        </div>
    </div>
</form>
@endsection