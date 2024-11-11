<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{asset('theme/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('theme/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="text-center">
            <div class="error mx-auto" data-text="@yield('title_code')">@yield('title_code')</div>
            <p class="lead text-gray-800 mb-3">@yield('title_err')</p>
            <p class="text-gray-500 mb-0">@yield('message')</p>
            @if(request()->is('admin/*'))
            <a href="{{ route('admin.dashboard') }}">&larr; Trở về trang chủ</a>
            @else
            <a href="{{ route('home') }}">&larr; Trở về trang chủ</a>
            @endif
        </div>
    </div>    
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('theme/admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('theme/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('theme/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('theme/admin/js/sb-admin-2.min.js')}}"></script>
</body>

</html>