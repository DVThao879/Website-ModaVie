@extends('admin.layouts.master')

@section('title')
Sửa tài khoản
@endsection

@section('content')
<a href="{{route('admin.users.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form action="{{route('admin.users.update', $user)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Main product information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin tài khoản</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="font-weight-bold mb-2">Chức vụ của {{ $user->name }} ({{ $user->role == 0 ? 'Người dùng' : 'Nhân viên' }})</div>
                            <label for="role" class="form-label">Phân quyền</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Nhân Viên</option>
                                <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Khách hàng</option>
                            </select>
                            @error('role')
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