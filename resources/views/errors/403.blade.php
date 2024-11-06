@extends('admin.layouts.master')

@section('content')
<div class="text-center">
    <div class="error mx-auto" data-text="403">403</div>
    <p class="lead text-gray-800 mb-3">Không có quyền truy cập</p>
    <p class="text-gray-500 mb-0">Có vẻ như bạn đang gặp lỗi nhỏ...</p>
    <a href="{{ route('admin.dashboard') }}">&larr; Trở về trang chủ</a>
</div>
@endsection
