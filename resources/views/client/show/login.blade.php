@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img"
        style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>login register page</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">login / register </li>
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
                                <h4> login </h4>
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
                                            {{-- @if ($errors->any())
                                            <div class="alert alert-secondary">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif --}}
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
                                                <input type="password" name="password" placeholder="Password">
                                                @error('password')
                                                <p class="text-danger">
                                                    {{$message}}
                                                </p>
                                                @enderror
                                            </div>
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input type="checkbox">
                                                    <label>Remember me</label>
                                                    <a href="{{route('forgot')}}">Forgot Password?</a>
                                                    <a href="{{route('register')}}">Register?</a>

                                                </div>
                                                {{-- @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif --}}
                                                <button type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="POST">
                                            @csrf
                                            <input type="text" name="name" value="{{ old('name') }}" required
                                                autofocus placeholder="Username">
                                            <input name="email" placeholder="Email" type="email"
                                                value="{{ old('email') }}" required>
                                            <input type="password" name="password" placeholder="Password">
                                            <input type="password" name="password_confirmation"
                                                placeholder="Re-enter password" required>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="button-box">
                                                <button type="submit">Register</button>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
