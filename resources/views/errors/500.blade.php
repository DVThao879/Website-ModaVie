@extends('admin.layouts.master')

@section('content')
<div class="text-center">
    <div class="error mx-auto" data-text="500">500</div>
    <p class="lead text-gray-800 mb-3">Lỗi máy chủ</p>
    <p class="text-gray-500 mb-0">Có vẻ như bạn đang gặp lỗi nhỏ...</p>
    <a href="{{ route('admin.dashboard') }}">&larr; Trở về trang chủ</a>
</div>
@endsection
