@extends('admin.layouts.master')

@section('title')
    Chi tiết kích thước
@endsection

@section('content')
<a href="{{route('admin.sizes.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết kích thước</h4>
        <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-light btn-sm">Chỉnh sửa</a>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-card-heading mr-2 text-primary"></i>
                <strong>ID:</strong> <span class="ml-2">{{$size->id}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-tag-fill mr-2 text-primary"></i>
                <strong>Size:</strong> <span class="ml-2">{{$size->name}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 mr-2 text-primary"></i>
                <strong>Ngày tạo:</strong> <span class="ml-2">{{$size->created_at->format('d/m/Y H:i')}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-pencil-square mr-2 text-primary"></i>
                <strong>Ngày sửa:</strong> <span class="ml-2">{{$size->updated_at->format('d/m/Y H:i')}}</span>
            </li>
        </ul>
    </div>
</div>
@endsection
