@extends('admin.layouts.master')

@section('title')
    Chi tiết màu sắc
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Chi tiết màu sắc</h4>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-card-heading mr-2"></i>
                <strong>ID:</strong> <span class="ml-2">{{$color->id}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-palette-fill mr-2"></i>
                <strong>Tên màu:</strong> <span class="ml-2">{{$color->name}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-palette mr-2"></i>
                <strong>Mã màu:</strong> <span class="ml-2">{{$color->hex_code}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 mr-2"></i>
                <strong>Ngày tạo:</strong> <span class="ml-2">{{$color->created_at->format('d/m/Y H:i')}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-pencil-square mr-2"></i>
                <strong>Ngày sửa:</strong> <span class="ml-2">{{$color->updated_at->format('d/m/Y H:i')}}</span>
            </li>
        </ul>
    </div>
</div>
@endsection
