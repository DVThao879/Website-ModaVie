@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img"
        style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Đăng nhập</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ</a>
                    </li>
                    <li class="active">Đăng nhập</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-register-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ms-auto me-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-bs-toggle="tab" href="#lg1">
                                <h4> Đăng nhập </h4>
                            </a>
                            {{-- <a class="active" data-bs-toggle="tab" href="#lg2">
                                <h4> register </h4>
                            </a> --}}
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        @if (session('status'))
                                        <script>
                                            window.onload = function() {
                                                alert("{{ session('status') }}");
                                            }
                                        </script>
                                            @endif
                                           
                                        <form action="{{route('login')}}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="email" name="email" placeholder="Email">
                                                @error('email')
                                                <p class="text-danger">
                                                    {{$message}}
                                                </p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <input type="password" name="password" placeholder="Mật khẩu">
                                                @error('password')
                                                <p class="text-danger">
                                                    {{$message}}
                                                </p>
                                                @enderror
                                            </div>
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember">
                                                    <label>Ghi nhớ tôi</label>
                                                    <a href="{{route('forgot')}}">Quên mật khẩu?</a>

                                                    <a href="{{route('register')}}">Bạn chưa có tài khoản? | </a>

                                                </div>  
                                                <button type="submit">Đăng nhập</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
