
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
                                <h4> Reset Password </h4>
                            </a>
                            {{-- <a class="active" data-bs-toggle="tab" href="#lg2">
                                <h4> register </h4>
                            </a> --}}
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('password.update') }}"> 
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">
                                                                    
                                            <div class="mb-4">
                                                <input type="hidden" name="email" placeholder="Email" value="{{ $email }}">
                                               
                                            </div>
                
                                            <div class="mb-4">
                                                <input type="password" name="password" placeholder="Password">
                                               
                                            </div>
                                            <div class="mb-4">
                                                <input type="password" name="password_confirmation" placeholder="Confirm Password">
                                               
                                            </div>
                                            @error('password')
                                            <p class="text-danger">
                                                {{$message}}
                                            </p>
                                            @enderror
                                            <div class="button-box">
                                                {{-- <div class="login-toggle-btn">
                                                    <input type="checkbox">
                                                    <label>Remember me</label>
                                                    <a href="#">Forgot Password?</a>
                                                </div> --}}
                                                {{-- @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif --}}
                                                <button type="submit">Reset Password</button>
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




