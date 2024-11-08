@extends('admin.layouts.master')

@section('title')
Chi tiết sản phẩm
@endsection

@section('content')
<a href="{{route('admin.products.index')}}" class="btn btn-primary mb-3">
    <i class="fa fa-arrow-left"></i> Quay lại
</a>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Chi tiết sản phẩm</h4>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-light btn-sm">Chỉnh sửa</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-card-heading mr-2 text-primary"></i>
                        <strong>ID:</strong> <span class="ml-2">{{$product->id}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-tag-fill mr-2 text-primary"></i>
                        <strong>Tên:</strong> <span class="ml-2">{{$product->name}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-link-45deg mr-2 text-primary"></i>
                        <strong>Slug:</strong> <span class="ml-2">{{$product->slug}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-upc-scan mr-2 text-primary"></i>
                        <strong>SKU:</strong> <span class="ml-2">{{$product->sku}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-folder mr-2 text-primary"></i>
                        <strong>Danh mục:</strong> <span class="ml-2">
                            {{$product->category->name}}
                            @if (!$product->category->is_active)
                                <span style="color: red;">(Bị khóa)</span>
                            @endif
                        </span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-pencil-square mr-2 text-primary"></i>
                        <strong>Ngày sửa:</strong> <span class="ml-2">{{$product->updated_at->format('d/m/Y H:i')}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-cash mr-2 text-primary"></i>
                        <strong>Giá min:</strong> <span class="ml-2">{{number_format($product->price_min, 0, ",", ".")}} VNĐ</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-cash-stack mr-2 text-primary"></i>
                        <strong>Giá max:</strong> <span class="ml-2">{{number_format($product->price_max, 0, ",", ".")}} VNĐ</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-toggle-on mr-2 text-primary"></i>
                        <strong>Trạng thái HĐ:</strong> <span class="ml-2">{!! $product->is_active ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Không hoạt động</span>' !!}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-eye-fill mr-2 text-primary"></i>
                        <strong>Lượt xem:</strong> <span class="ml-2">{{$product->view}}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-calendar3 mr-2 text-primary"></i>
                        <strong>Ngày tạo:</strong> <span class="ml-2">{{$product->created_at->format('d/m/Y H:i')}}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <li class="mb-3 d-flex align-items-start">
                    <i class="bi bi-file-text mr-2 text-primary"></i>
                    <div>
                        <strong>Mô tả:</strong>
                        <div class="mt-2" id="shortDescription">
                            {!! substr($product->description, 0, 200) !!}...
                            <a href="javascript:void(0);" onclick="showMore()">Xem thêm</a>
                        </div>
                        <div class="mt-2" id="fullDescription" style="display:none;">
                            {!! $product->description !!}
                            <a href="javascript:void(0);" onclick="showLess()">Ẩn bớt</a>
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <h4 class="mb-3">Ảnh sản phẩm</h4>
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="">
                    <img src="{{ Storage::url($product->img_thumb) }}" alt="Product Image" class="img-fluid" style="max-width: 100%;">
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    @foreach ($product->galleries as $item)
                    <div class="col-6 col-md-4 col-lg-3 mb-2">
                        <img src="{{ Storage::url($item->image) }}" alt="Gallery Image" class="" style="max-width: 100%; max-height: 150px; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <h4 class="mb-3">Biến thể của sản phẩm</h4>
    
        @if($product->variants->isEmpty())
            <!-- Thông báo khi sản phẩm không có biến thể -->
            <div class="alert alert-warning">
                Sản phẩm này hiện không có biến thể nào
            </div>
        @else
            <!-- Bảng hiển thị biến thể -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên SP</th>
                        <th>Kích thước</th>
                        <th>Màu sắc</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Giá KM</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->variants as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $item->size->name }}</td>
                        <td>
                            <div class="d-flex">
                                <div class="rounded-circle mr-2" style="width: 20px; height: 20px; background-color: {{ $item->color->hex_code }};"></div>
                                <span>{{ $item->color->hex_code }}</span>
                            </div>
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{number_format($item->price, 0, ",", ".")}} VNĐ</td>
                        <td>{{number_format($item->price_sale, 0, ",", ".")}} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
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
