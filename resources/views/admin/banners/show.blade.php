@extends('admin.layouts.master')

@section('title')
    Chi tiết banner
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết banner</h4>
        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-light btn-sm">Chỉnh sửa</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-card-heading text-primary mr-2"></i>
                <strong>ID:</strong>
                <span class="ml-2">{{$banner->id}}</span>
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-tag-fill text-primary mr-2"></i>
                <strong>Tiêu đề:</strong>
                <span class="ml-2">{{$banner->title}}</span>
            </div>
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <i class="bi bi-file-earmark-text text-primary mr-2"></i>
                <strong>Mô tả:</strong>
                <span class="ml-2">{{$banner->description}}</span>
            </div>
            <div class="col-md-12 mb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-image-fill text-primary mr-2"></i>
                    <strong>Ảnh:</strong>
                </div>
                <div class="mt-2 text-center">
                    <img src="{{ Storage::url($banner->image) }}" alt="Banner Image" class="img-fluid rounded border" style="max-width: 100%; height: auto;">
                </div>
            </div>
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <i class="bi bi-check-circle text-primary mr-2"></i>
                <strong>Trạng thái:</strong>
                <span class="ml-2">{!! $banner->is_active ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Không hoạt động</span>' !!}</span>
            </div>
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 text-primary mr-2"></i>
                <strong>Ngày tạo:</strong>
                <span class="ml-2">{{$banner->created_at->format('d/m/Y H:i')}}</span>
                <i class="bi bi-pencil-square text-primary ml-4 mr-2"></i>
                <strong>Ngày sửa:</strong>
                <span class="ml-2">{{$banner->updated_at->format('d/m/Y H:i')}}</span>
            </div>
        </div>
    </div>
</div>
@endsection
