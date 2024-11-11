@extends('admin.layouts.master')

@section('title')
Đổi mật khẩu
@endsection

@section('content')
<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Thay đổi mật khẩu</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.profile.changePassword') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label for="current_password" class="col-sm-4 col-form-label">Mật khẩu hiện tại</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Nhập mật khẩu cũ" id="current_password" name="current_password">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('current_password', 'eyeIconCurrent')">
                                <i class="fa fa-eye" id="eyeIconCurrent"></i>
                            </span>
                        </div>
                    </div>
                    @error('current_password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row">
                <label for="new_password" class="col-sm-4 col-form-label">Mật khẩu mới</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Nhập mật khẩu mới" id="new_password" name="new_password">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('new_password', 'eyeIconNew')">
                                <i class="fa fa-eye" id="eyeIconNew"></i>
                            </span>
                        </div>
                    </div>
                    @error('new_password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>            

            <div class="form-group row">
                <label for="new_password_confirmation" class="col-sm-4 col-form-label">Xác nhận mật khẩu mới</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" id="new_password_confirmation" name="new_password_confirmation">
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('new_password_confirmation', 'eyeIconConfirm')">
                                <i class="fa fa-eye" id="eyeIconConfirm"></i>
                            </span>
                        </div>
                    </div>
                    @error('new_password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>            

            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
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