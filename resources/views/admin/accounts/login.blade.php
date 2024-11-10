





<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom fonts for this template-->
    <link href="{{asset('theme/admin/css/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('theme/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Chào mừng trở lại!</h1>
                                    </div>
                                    <form class="user" method="post" action="{{ route('admin.checkLogin') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control "
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Email" name="email" value="{{ old('email') }} "required>
                                                @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        
                                      
                                        <div class="form-group">
                                            <label>Mật khẩu</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password" class="form-control"
                                                    placeholder="Mật khẩu" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" onclick="togglePassword()">
                                                        <i class="fa fa-eye" id="eyeIcon"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        @if ($errors->has('err'))
                                        <span class="text-danger">{{ $errors->first('err') }}</span>
                                        @endif

                                        <div class="form-group d-flex justify-content-between align-items-center">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" name="remember" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Ghi nhớ tôi</label>
                                            </div>
                                            <div>
                                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Đăng nhập</button>

                                       
                                       
                                    </form>
                                    
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('theme/admin/css/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('theme/admin/css/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('theme/admin/css/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('theme/admin/css/js/sb-admin-2.min.js')}}"></script>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");

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
</body>

</html>