@extends('admin.layouts.master')

@section('title')
Sửa sản phẩm
@endsection
@section('style-libs')
<!-- Plugins css -->
<link href="{{asset('theme/admin/libs/dropzone/dropzone.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('script-libs')
<!-- ckeditor -->
<script src="{{asset('theme/admin/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')}}"></script>
<!-- dropzone js -->
<script src="{{asset('theme/admin/libs/dropzone/dropzone-min.js')}}"></script>

<script src="{{asset('theme/admin/js/create-product.init.js')}}"></script>
@endsection
@section('content')
<a href="{{route('admin.products.index')}}" class="btn btn-success mb-3">
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
                            <label class="form-label">Mô tả</label>
                            <textarea id="ckeditor-classic" name="description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="img_thumb" class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="img_thumb" name="img_thumb">
                            @error('img_thumb')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if($product->img_thumb)
                            <img src="{{ Storage::url($product->img_thumb) }}" alt="Product Thumbnail" class="img-thumbnail mt-2" width="150">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="gallery" class="form-label">Thư viện ảnh</label>
                            <input type="file" class="form-control" id="gallery" name="product_galleries[]" multiple>
                            @error('product_galleries.*')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if($product->galleries->count())
                            <div class="mt-2">
                                @foreach($product->galleries as $gallery)
                                <img src="{{ Storage::url($gallery->image) }}" alt="Product Gallery" class="img-thumbnail" width="100">
                                @endforeach
                            </div>
                            @endif
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
                                <option value="">--Chọn danh mục--</option>
                                @foreach($categories as $item)
                                <option value="{{$item->id}}" {{ old('category_id', $product->category_id) == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">Trạng thái HĐ</label>
                            <select class="form-control form-select-lg" id="choices-publish-status-input" aria-label="Default select example" name="is_active" required>
                                <option value="">--Chọn trạng thái--</option>
                                <option value="1" {{ old('is_active', $product->is_active) == '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ old('is_active', $product->is_active) == '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                            @error('is_active')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="sku" class="form-label">Mã sản phẩm</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')
                            <div class="text-danger">{{ $message }}</div>
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
                            <tr id="variant-{{ $index }}">
                                <td>
                                    <select name="variants[{{ $index }}][size_id]" class="form-control" required>
                                        <option value="">Chọn size</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ $size->id == $variant['size_id'] ? 'selected' : '' }}>
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
                                        <option value="{{ $color->id }}" {{ $color->id == $variant['color_id'] ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("variants.{$index}.color_id")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][quantity]" class="form-control" value="{{ $variant['quantity'] }}" required>
                                    @error("variants.{$index}.quantity")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ $variant['price'] }}" required>
                                    @error("variants.{$index}.price")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price_sale]" class="form-control" value="{{ $variant['price_sale'] }}" required>
                                    @error("variants.{$index}.price_sale")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-variant-btn" data-variant-id="{{ $index }}">Xóa</button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <!-- Đoạn mã xử lý trường hợp không có biến thể nào -->
                            @foreach ($product->variants as $index => $variant)
                            <tr id="variant-{{ $index }}">
                                <td>
                                    <select name="variants[{{ $index }}][size_id]" class="form-control" required>
                                        <option value="">Chọn size</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ $size->id == old("variants.{$index}.size_id", $variant->size_id) ? 'selected' : '' }}>
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
                                        <option value="{{ $color->id }}" {{ $color->id == old("variants.{$index}.color_id", $variant->color_id) ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error("variants.{$index}.color_id")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][quantity]" class="form-control" value="{{ old("variants.{$index}.quantity", $variant->quantity) }}" required>
                                    @error("variants.{$index}.quantity")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ old("variants.{$index}.price", $variant->price) }}" required>
                                    @error("variants.{$index}.price")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" name="variants[{{ $index }}][price_sale]" class="form-control" value="{{ old("variants.{$index}.price_sale", $variant->price_sale) }}" required>
                                    @error("variants.{$index}.price_sale")
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger remove-variant-btn" data-variant-id="{{ $index }}">Xóa</button>
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
        <button class="btn btn-success w-sm">Sửa</button>
    </div>
</form>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function attachDeleteEventListeners() {
            const deleteButtons = document.querySelectorAll('.remove-variant-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const variantId = this.getAttribute('data-variant-id');
                    document.getElementById(`variant-${variantId}`).remove();
                });
            });
        }

        // Gọi hàm này ngay khi trang tải xong để gắn sự kiện cho các nút "Xóa"
        attachDeleteEventListeners();

        // Sự kiện khi nhấn nút "Thêm biến thể"
        document.getElementById('add-variant-btn').addEventListener('click', function() {
            const container = document.getElementById('variants-container');
            const variantIndex = container.children.length;

            const variantHtml = `
        <tr id="variant-${variantIndex}">
            <td>
                <select name="variants[${variantIndex}][size_id]" class="form-control" required>
                    <option value="">Chọn size</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="variants[${variantIndex}][color_id]" class="form-control" required>
                    <option value="">Chọn màu</option>
                    @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="variants[${variantIndex}][quantity]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variants[${variantIndex}][price]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variants[${variantIndex}][price_sale]" class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger remove-variant-btn" data-variant-id="${variantIndex}">Xóa</button>
            </td>
        </tr>
        `;

            container.insertAdjacentHTML('beforeend', variantHtml);

            // Gắn lại sự kiện cho nút "Xóa" sau khi thêm mới biến thể
            attachDeleteEventListeners();
        });

        const form = document.getElementById('myForm');

        form.addEventListener('submit', function(event) {
            const container = document.getElementById('variants-container');
            if (container.children.length === 0) {
                alert('Vui lòng thêm biến thể sản phẩm trước khi lưu');
                event.preventDefault();
                return;
            }
        });
        
    });
</script>
@endsection