@extends('admin.layouts.master')

@section('title')
Sửa banner
@endsection

@section('content')
<a href="{{route('admin.banners.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form action="{{route('admin.banners.update', $banner)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Main product information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin banner</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" placeholder="Nhập tiêu đề..." name="title" value="{{ old('title', $banner->title) }}">
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh banner</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @if($banner->image)
                            <img id="preview" src="{{ Storage::url($banner->image) }}" alt="Xem trước ảnh" style="max-width: 100%; height: auto; margin-top: 10px;" class="img-thumbnail">
                            @else
                            <img id="preview" src="#" alt="Xem trước ảnh" style="display:none; max-width: 100%; height: auto; margin-top: 10px;">
                            @endif
                            @error('image')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Đường dẫn</label>
                            <input type="url" class="form-control" id="link" placeholder="https://example.com" name="link" value="{{ old('link', $banner->link) }}">
                            @error('link')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!--                        Button -->
            <div class="d-flex justify-content-center mb-3">
                <button class="btn btn-success w-sm" type="submit">Cập nhật</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
    jQuery(document).ready(function() {
        jQuery('#image').on('change', function(e) {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    jQuery('#preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endsection