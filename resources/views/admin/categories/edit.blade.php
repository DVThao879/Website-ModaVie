@extends('admin.layouts.master')

@section('title')
Sửa danh mục
@endsection

@section('content')
<a href="{{route('admin.categories.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form action="{{route('admin.categories.update', $category)}}" method="post">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Main product information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin danh mục</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập tên danh mục..." value="{{ old('name', $category->name) }}" name="name" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
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