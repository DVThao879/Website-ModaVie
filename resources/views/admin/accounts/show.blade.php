@extends('admin.layouts.master')

@section('title')
    Chi tiết banner
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết banner</h4>
        @if(Auth::user()->role != 2)
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-light btn-sm">Chỉnh sửa</a>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-card-heading text-primary mr-2"></i>
                <strong>ID:</strong>
                <span class="ml-2">{{$user->id}}</span>
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-tag-fill text-primary mr-2"></i>
                <strong>Tên tài khoản:</strong>
                <span class="ml-2">{{$user->name}}</span>
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-file-earmark-text text-primary mr-2"></i>
                <strong>Email:</strong>
                @if(!empty($user->email))
                <span class="ml-2">{{$user->email}}</span>
                @else
                <span class="ml-2 text-danger">Chưa cập nhật!</span>
                @endif
            </div>
            <div class="col-md-6 mb-3 d-flex align-items-center">
                <i class="bi bi-geo-alt text-primary mr-2"></i>
                <strong>Địa chỉ:</strong>
                @if(!empty($user->address))
                <span class="ml-2">{{$user->address}}</span>
                @else
                <span class="ml-2 text-danger">Chưa cập nhật!</span>
                @endif
            </div>
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <i class="bi bi-telephone text-primary mr-2"></i>
                <strong>Số điện thoại:</strong>
                @if(!empty($user->phone))
                <span class="ml-2">{{$user->phone}}</span>
                @else
                <span class="ml-2 text-danger">Chưa cập nhật!</span>
                @endif
            </div>
            <div class="col-md-12 mb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-image-fill text-primary mr-2"></i>
                    <strong>Ảnh:</strong>
                </div>
                <div class="mt-2 text-center">
                    @if(!empty($user->image))
                    <img src="{{ Storage::url($user->image) }}" alt="Banner Image" class="img-fluid rounded border" style="max-width: 100%; height: auto;">
                    @else
                    <div class="text-danger">Chưa cập nhật ảnh!</div>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <i class="bi bi-check-circle text-primary mr-2"></i>
                <strong>Trạng thái:</strong>
                <span class="ml-2">{!! $user->is_active ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Không hoạt động</span>' !!}</span>
            </div>
            <div class="col-md-12 mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 text-primary mr-2"></i>
                <strong>Ngày tạo:</strong>
                <span class="ml-2">{{$user->created_at->format('d/m/Y H:i')}}</span>
                <i class="bi bi-pencil-square text-primary ml-4 mr-2"></i>
                <strong>Ngày sửa:</strong>
                <span class="ml-2">{{$user->updated_at->format('d/m/Y H:i')}}</span>
            </div>
        </div>
    </div>
</div>
@endsection
