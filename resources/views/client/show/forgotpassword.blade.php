@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img"
        style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Quên mật khẩu</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ</a>
                    </li>
                    <li class="active">Quên mật khẩu</li>
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
                                <h4> Quên mật khẩu </h4>
                            </a>
                           
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('forgot') }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="email" name="email" placeholder="Email">
                                            @if (session('status'))
                                            <script>
                                                window.onload = function() {
                                                    alert("{{ session('status') }}");
                                                }
                                            </script>
                                                @endif
                                            @error('email')
                                            <p class="text-danger">
                                                {{$message}}
                                            </p>
                                            @enderror 
                                            </div>

                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    {{-- <input type="checkbox"> --}}
                                                    {{-- <label>Login</label> --}}
                                                    <a href="{{route('register')}}">Đăng ký?</a>

                                                    <a href="{{route('login')}}">Bạn đã có tài khoản, </a>

                                                </div>
                                                <button type="submit">Gửi</button>
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
