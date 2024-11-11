@extends('admin.layouts.master')

@section('title')
    Chi tiết bài viết
@endsection

@section('content')
<a href="{{route('admin.blogs.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết bài viết</h4>
        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-light btn-sm">Chỉnh sửa</a>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-card-heading mr-2 text-primary"></i>
                <strong>ID:</strong> <span class="ml-2">{{$blog->id}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-tag-fill mr-2 text-primary"></i>
                <strong>Tiêu đề:</strong> <span class="ml-2">{{$blog->title}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-person mr-2 text-primary"></i>
                <strong>Tiêu đề:</strong> <span class="ml-2">{{$blog->user->name}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-check-circle mr-2 text-primary"></i>
                <strong>Trạng thái:</strong> <span class="ml-2">{!! $blog->is_active ? '<span class="text-success mr-1">Hoạt động</span>' : '<span class="text-danger mr-1">Không hoạt động</span>' !!}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-calendar3 mr-2 text-primary"></i>
                <strong>Ngày tạo:</strong> <span class="ml-2">{{$blog->created_at->format('d/m/Y H:i')}}</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
                <i class="bi bi-pencil-square mr-2 text-primary"></i>
                <strong>Ngày sửa:</strong> <span class="ml-2">{{$blog->updated_at->format('d/m/Y H:i')}}</span>
            </li>
            <li class="mb-3">
                <i class="bi bi-check-circle mr-2 text-primary"></i>
                <strong>Nội dung:</strong>
                <div class="mt-2" id="shortDescription">
                    {!! substr($blog->content, 0, 200) !!}...
                    <a href="javascript:void(0);" onclick="showMore()">Xem thêm</a>
                </div>
                <div class="mt-2" id="fullDescription" style="display:none;">
                    {!! $blog->content !!}
                    <a href="javascript:void(0);" onclick="showLess()">Ẩn bớt</a>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('script')
<script>
    function showMore() {
        document.getElementById('shortDescription').style.display = 'none'; // Hide short description
        document.getElementById('fullDescription').style.display = 'block'; // Show full description
    }
    
    function showLess() {
        document.getElementById('shortDescription').style.display = 'block'; // Show short description
        document.getElementById('fullDescription').style.display = 'none'; // Hide full description
    }
</script>
@endsection