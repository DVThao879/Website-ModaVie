@extends('admin.layouts.master')

@section('title')
Sửa sản phẩm
@endsection

@section('content')
<a href="{{route('admin.products.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<form id="myForm" action="{{route('admin.products.update', $product)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <!--   left content-->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Main products information -->
                <a href="#collapseProductInfo" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin sản phẩm</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseProductInfo">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên</label>
                            <input type="text" class="form-control" id="name" placeholder="Tên sản phẩm" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price_min" class="form-label">Giá min</label>
                            <input type="text" class="form-control" id="price_min" placeholder="Giá sản phẩm" name="price_min" value="{{ old('price_min', $product->price_min) }}" required>
                            @error('price_min')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price_max" class="form-label">Giá max</label>
                            <input type="text" class="form-control" id="price_max" placeholder="Giá sản phẩm" name="price_max" value="{{ old('price_max', $product->price_max) }}" required>
                            @error('price_max')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">Mô tả</label>
                            <textarea id="editor" name="description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gallery" class="form-label">Thư viện ảnh</label>
                            <input type="file" class="form-control" id="gallery" name="product_galleries[]" multiple accept="image/*">
                            <!-- Hiển thị lỗi cho từng ảnh -->
                            @if ($errors->has('product_galleries.*'))
                            @foreach ($errors->get('product_galleries.*') as $key => $messages)
                            @foreach ($messages as $message)
                            <small class="text-danger">{{ $message }}</small><br>
                            @endforeach
                            @endforeach
                            @endif
                            <!-- Xem trước các ảnh đã có và ảnh mới được chọn -->
                            <div id="image-preview" class="row mt-3">
                                @foreach($product->galleries as $gallery)
                                <div class="col-md-2 mb-3">
                                    <img class="img-thumbnail" style="width:100%;" src="{{ Storage::url($gallery->image) }}" alt="Gallery Image">
                                </div>
                                @endforeach
                                <!-- Ảnh được chọn sẽ hiển thị tại đây -->
                            </div>
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
                        <div class="mb-3">
                            <label for="choices-category-input" class="form-label">Danh mục sản phẩm</label>
                            <select class="form-control" aria-label="Default select example"
                                id="choices-category-input" name="category_id" required>
                                <option value="">--Vui lòng chọn--</option>
                                @foreach($categories as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('category_id', $product->category_id) == $item->id ? 'selected' : '' }}
                                    @if(!$item->is_active) disabled @endif>
                                    {{ $item->name }}
                                    @if(!$item->is_active) (Danh mục bị vô hiệu hóa) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sku" class="form-label">Mã sản phẩm</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="img_thumb" class="form-label">Ảnh đại diện</label>
                            <!-- Khung chứa hình ảnh -->
                            <div style="width: 100%; height: auto;">
                                <img id="img-preview"
                                    src="{{ $product->img_thumb ? Storage::url($product->img_thumb) : 'https://tse4.mm.bing.net/th?id=OIP.EkljFHN5km7kZIZpr96-JwAAAA&pid=Api&P=0&h=220' }}"
                                    alt="Ảnh đại diện"
                                    class="img-thumbnail"
                                    style="width: 100%; height: auto; object-fit: cover; cursor: pointer;">
                            </div>
                            <!-- Input file ẩn -->
                            <input type="file" id="img_thumb" name="img_thumb" class="form-control d-none" accept="image/*">
                            @error('img_thumb')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end right content       -->
    </div>
    {{-- Biến thể sản phẩm--}}
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseProductGallery1" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Biến thể sản phẩm</h6>
        </a>
        <div class="collapse show" id="collapseProductGallery1">
            <div class="card-body">
                <div class="mb-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Màu</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Giá KM</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="variants-container">
                            @if(old('variants'))
                            @foreach(old('variants', []) as $index => $variant)
                            <tr class="form-variant" id="variant-{{ $index }}" data-index={{ $index }}>
                                <td>
                                    <select name="variants[{{ $index }}][size_id]" class="form-control" required>
                                        <option value="">Chọn size</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ old("variants.{$index}.size_id") == $size->id ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("variants.{$index}.size_id")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <select name="variants[{{ $index }}][color_id]" class="form-control" required>
                                        <option value="">Chọn màu</option>
                                        @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ old("variants.{$index}.color_id") == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("variants.{$index}.color_id")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][quantity]" class="form-control" value="{{ old("variants.{$index}.quantity") }}" required>
                                    @error("variants.{$index}.quantity")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ old("variants.{$index}.price") }}" required>
                                    @error("variants.{$index}.price")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price_sale]" class="form-control" value="{{ old("variants.{$index}.price_sale") }}" required>
                                    @error("variants.{$index}.price_sale")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-variant-btn">Xóa</button>
                                </td>
                            </tr>
                            @endforeach
                            @elseif($product->variants->isEmpty())
                            <!-- Hiển thị thông báo khi không có biến thể -->
                            <tr class="form-variant" id="variant-0" data-index="0">
                                <td>
                                    <select name="variants[0][size_id]" class="form-control" required>
                                        <option value="">Chọn size</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">
                                            {{ $size->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="variants[0][color_id]" class="form-control" required>
                                        <option value="">Chọn màu</option>
                                        @foreach($colors as $color)
                                        <option value="{{ $color->id }}">
                                            {{ $color->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="variants[0][quantity]" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" name="variants[0][price]" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" name="variants[0][price_sale]" class="form-control" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-variant-btn">Xóa</button>
                                </td>
                            </tr>
                            @else
                            <!-- Đoạn mã xử lý trường hợp không có biến thể nào -->
                            @foreach ($product->variants as $index => $variant)
                            <tr class="form-variant" id="variant-{{ $index }}" data-index="{{ $index }}">
                                <td>
                                    <select name="variants[{{ $index }}][size_id]" class="form-control" required>
                                        <option value="">Chọn size</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ $size->id == old("variants.{$index}.size_id", $variant->size_id) ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="variants[{{ $index }}][color_id]" class="form-control" required>
                                        <option value="">Chọn màu</option>
                                        @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ $color->id == old("variants.{$index}.color_id", $variant->color_id) ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][quantity]" class="form-control" value="{{ old("variants.{$index}.quantity", $variant->quantity) }}" required>
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ old("variants.{$index}.price", $variant->price) }}" required>
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price_sale]" class="form-control" value="{{ old("variants.{$index}.price_sale", $variant->price_sale) }}" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-variant-btn">Xóa</button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <button class="btn btn-info" id="add-variant-btn" type="button">Thêm biến thể</button>
                </div>
            </div>
        </div>
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
        //Thêm biến thể
        jQuery('#add-variant-btn').on('click', function() {
            var currentRows = jQuery('#variants-container .form-variant');
            var newIndex = 0;

            // Tìm chỉ số mới không trùng từ thuộc tính data-index
            if (currentRows.length > 0) {
                var existingIndexes = currentRows.map(function() {
                    return parseInt(jQuery(this).attr('data-index'));
                }).get();
                newIndex = Math.max.apply(Math, existingIndexes) + 1;
            }

            // Tạo HTML cho biến thể mới
            var newVariantRow = `
        <tr class="form-variant" id="variant-${newIndex}" data-index="${newIndex}">
            <td>
                <select name="variants[${newIndex}][size_id]" class="form-control" required>
                    <option value="">Chọn size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="variants[${newIndex}][color_id]" class="form-control" required>
                    <option value="">Chọn màu</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="variants[${newIndex}][quantity]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variants[${newIndex}][price]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variants[${newIndex}][price_sale]" class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger remove-variant-btn">Xóa</button>
            </td>
        </tr>
        `;

            // Thêm hàng mới vào container
            jQuery('#variants-container').append(newVariantRow);
        });

        // Xóa biến thể
        jQuery(document).on('click', '.remove-variant-btn', function() {
            if (jQuery('.form-variant').length > 1) {
                jQuery(this).closest('.form-variant').remove(); // Xóa hàng hiện tại
            } else {
                alert('Bạn cần ít nhất một biến thể');
            }
        });

        // Abum ảnh
        jQuery('#gallery').on('change', function() {
            var files = this.files;
            var previewContainer = jQuery('#image-preview');
            previewContainer.html('');

            if (files) {
                jQuery.each(files, function(index, file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imageCol = jQuery('<div class="col-md-2 mb-3"></div>');
                        var imageElement = jQuery('<img class="img-thumbnail" style="width:100%;">');
                        imageElement.attr('src', e.target.result);
                        imageCol.append(imageElement);
                        previewContainer.append(imageCol);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });

        // Ảnh đại diện
        jQuery('#img-preview').on('click', function() {
            jQuery('#img_thumb').click();
        });

        // Hiển thị hình ảnh đã chọn
        jQuery('#img_thumb').on('change', function(event) {
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