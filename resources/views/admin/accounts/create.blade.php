@extends('admin.layouts.master')

@section('title')
Thêm tài khoản
@endsection

@section('content')
<a href="{{route('admin.users.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data">
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
                            <label for="name" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập tên" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Nhập email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Điện thoại</label>
                            <input type="number" class="form-control" id="phone" placeholder="Nhập số điện thoại" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" required accept="image/*">
                            <div class="mt-1">
                                <img id="preview-avatar" src="#" alt="Ảnh xem trước" style="display: none; max-width: 200px; height: auto; border-radius: 50%; border: 2px solid #ccc;">
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('password', 'eyeIcon')">
                                        <i class="fa fa-eye" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" placeholder="Nhập lại mật khẩu" name="password_confirmation" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="togglePassword('password_confirmation', 'eyeIconConfirm')">
                                        <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password_confirmation')
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

@section('script')
<script>
    jQuery(document).ready(function() {
    jQuery('#image').on('change', function(e) {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                jQuery('#preview-avatar').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]); // Đọc file ảnh
        }
    });
});
</script>
<script>
function togglePassword(inputId, iconId) {
    var passwordField = document.getElementById(inputId);
    var eyeIcon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>
@endsection