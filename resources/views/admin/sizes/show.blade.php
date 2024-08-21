@extends('admin.layouts.master')

@section('title')
    Chi tiết size
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Chi tiết size</h4>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-card-heading mr-2"></i>
                <strong>ID:</strong> <span class="ml-2">{{$size->id}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-tag-fill mr-2"></i>
                <strong>Size:</strong> <span class="ml-2">{{$size->name}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 mr-2"></i>
                <strong>Ngày tạo:</strong> <span class="ml-2">{{$size->created_at->format('d/m/Y H:i')}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-pencil-square mr-2"></i>
                <strong>Ngày sửa:</strong> <span class="ml-2">{{$size->updated_at->format('d/m/Y H:i')}}</span>
            </li>
        </ul>
    </div>
</div>
@endsection
