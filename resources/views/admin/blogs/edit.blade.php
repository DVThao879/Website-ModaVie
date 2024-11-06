@extends('admin.layouts.master')

@section('title')
Sửa bài viết
@endsection

@section('content')
<a href="{{route('admin.blogs.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form id="myForm" action="{{route('admin.blogs.update', $blog)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <!--   left content-->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Main products information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin bài viết</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" placeholder="Tiêu đề bài viết" name="title" value="{{ old('title', $blog->title) }}" required>
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">Mô tả</label>
                            <textarea id="editor" name="content">{{ old('content', $blog->content) }}</textarea>
                            @error('content')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end left content    -->
        <!-- right content          -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseStatus" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Trạng thái sản phẩm</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseStatus">
                    <!-- end card body -->
                    <div class="card-body">
                        <div>
                            <label for="img_avt" class="form-label">Ảnh đại diện</label>
                            <!-- Khung chứa hình ảnh -->
                            <div style="width: 100%; height: auto;">
                                <img id="img-preview"
                                    src="{{ $blog->img_avt ? Storage::url($blog->img_avt) : 'https://tse4.mm.bing.net/th?id=OIP.EkljFHN5km7kZIZpr96-JwAAAA&pid=Api&P=0&h=220' }}"
                                    alt="Ảnh đại diện"
                                    class="img-thumbnail"
                                    style="width: 100%; height: auto; object-fit: cover; cursor: pointer;">
                            </div>
                            <!-- Input file ẩn -->
                            <input type="file" id="img_avt" name="img_avt" class="form-control d-none" accept="image/*">
                            @error('img_avt')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end right content       -->
    </div>
    <!--                        Button -->
    <div class="text-center mb-3">
        <button class="btn btn-success w-sm">Cập nhật</button>
    </div>
</form>
@endsection

@section('script')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('editor', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
        removePlugins: 'exportpdf',
        clipboard_handleImages: false,
    });
</script>
<script>
    jQuery(document).ready(function() {
        // Ảnh đại diện
        jQuery('#img-preview').on('click', function() {
            jQuery('#img_avt').click();
        });

        // Hiển thị hình ảnh đã chọn
        jQuery('#img_avt').on('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    jQuery('#img-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

    });
</script>
@endsection