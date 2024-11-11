@extends('admin.layouts.master')

@section('title')
Hồ sơ cá nhân
@endsection

@section('content')
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thông tin tài khoản</h6>
    </div>
    <div class="card-body">
        <div class="mb-4">
            @if(auth()->user()->image)
                <img id="profile-image" src="{{ Storage::url(auth()->user()->image) }}" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            @else
                <img id="profile-image" src="https://via.placeholder.com/150" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            @endif
        </div>
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Họ và tên</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Nhập họ và tên" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" placeholder="Nhập email" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Số điện thoại</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Nhập số điện thoại" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Địa chỉ</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Nhập địa chỉ" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-sm-3 col-form-label">Ảnh đại diện</label>
                <div class="col-sm-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" onchange="previewImage()" accept="image/*">
                        <label class="custom-file-label" for="image">Chọn ảnh...</label>
                        @error('image')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.profile.showChangePasswordForm') }}" class="btn btn-secondary ml-2">Đổi mật khẩu</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    // Hiển thị ảnh đã chọn
    function previewImage() {
        var file = document.getElementById("image").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            document.getElementById("profile-image").src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
