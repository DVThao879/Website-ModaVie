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
                            {{-- <a  data-bs-toggle="tab" href="#lg1">
                                <h4> login </h4>
                            </a> --}}
                            <a class="active" data-bs-toggle="tab" href="#lg2">
                                <h4> register </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            {{-- <div id="lg1" class="tab-pane ">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="#" method="post">
                                            <input type="text" name="user-name" placeholder="Username">
                                            <input type="password" name="user-password" placeholder="Password">
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input type="checkbox">
                                                    <label>Remember me</label>
                                                    <a href="#">Forgot Password?</a>
                                                </div>
                                                <button type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}
                            <div id="lg2" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('register') }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="text" name="name" value="{{ old('name') }}" 
                                                autofocus placeholder="Username">
                                                @error('name')
                                                <p class="text-danger">
                                                    {{$message}}
                                                </p>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <input name="email" placeholder="Email" type="email"
                                                value="{{ old('email') }}" >
                                                @error('email')
                                                <p class="text-danger">
                                                    {{$message}}
                                                </p>
                                                @enderror
                                            </div>
                                           <div class="mb-4">
                                            <input type="password" name="password" placeholder="Password" >

                                           </div>
                                           <div class="mb-4">
                                            <input type="password" name="password_confirmation"
                                            placeholder="Re-enter password" >
                                            @error('password')
                                            <p class="text-danger">
                                                {{$message}}
                                            </p>
                                            @enderror
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
                                            <div class="button-box">
                                                <button type="submit">Register</button>
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
