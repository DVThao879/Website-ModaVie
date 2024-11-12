@extends('client.layouts.app')

@section('content')
 <style>
    .product-description-wrapper img {
    max-width: 100%; 
    max-height: 300px; 
    object-fit: contain; 
}


                              
 </style>

    


    <div class="breadcrumb-area pt-95 pb-100 bg-img"
        style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Chi tiết sản phẩm</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ</a>
                    </li>
                    <li class="active">Chi tiết sản phẩm</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-details-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-img">
                        <div class="zoompro-border zoompro-span">
                            <!-- Hình ảnh chính của sản phẩm -->
                            <img class="zoompro" src="{{ Storage::url($product->img_thumb) }}"
                                data-zoom-image="{{ Storage::url($product->img_thumb) }}" alt=""
                                style="width: 100%; height: auto; display: block;">

                        </div>
                        <div id="gallery" class="mt-20 product-dec-slider">
                            <a href="{{ Storage::url($product->img_thumb) }}"
                                data-image="{{ Storage::url($product->img_thumb) }}"
                                data-zoom-image="{{ Storage::url($product->img_thumb) }}"
                                style="display: block; width: 100px; margin-right: 10px; margin-bottom: 10px; text-decoration: none;">
                                <img src="{{ Storage::url($product->img_thumb) }}" alt="Gallery Image"
                                    style="width: 100%; height: auto; display: block;" />
                            </a>
                            @foreach ($product->galleries as $galleri)
                                <a href="{{ Storage::url($galleri->image) }}"
                                    data-image="{{ Storage::url($galleri->image) }}"
                                    data-zoom-image="{{ Storage::url($galleri->image) }}"
                                    style="display: block; width: 100px; margin-right: 10px; margin-bottom: 10px; text-decoration: none;">
                                    <img src="{{ Storage::url($galleri->image) }}" alt="Gallery Image"
                                        style="width: 100%; height: auto; display: block;" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="product-details-content ml-30">
                        <h2>{{ $product->name }}</h2>
                        @php
                            $defaultVariant = $product->variants->first(); // Lấy biến thể đầu tiên
                            $price = $defaultVariant
                                ? number_format($defaultVariant->price, 0, ',', '.')
                                : 'Chưa có giá';
                            $price_sale = $defaultVariant
                                ? number_format($defaultVariant->price_sale, 0, ',', '.')
                                : 'Chưa có giá';
                            $quantity = $defaultVariant ? $defaultVariant->quantity : 'Chưa có số lượng';
                        @endphp

                        <div class="product-details-price">
                            <span id="product-price">{{ $price_sale }} VND</span>
                            <span class="ml-10 old" id="product-old-price">{{ $price }} VND</span>
                        </div>


                        <div class="pro-details-rating-wrap">
                            <div class="pro-details-rating">
                                <i class="la la-star"></i>
                                <i class="la la-star"></i>
                                <i class="la la-star"></i>
                                <i class="la la-star"></i>
                                <i class="la la-star"></i>
                            </div>
                            <span><a href="#">{{ $product->view }} lượt xem</a></span>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1;">
                                    <span>Size</span>
                                    <select id="size-select" name="size"
                                        style="width: 100%; padding: 5px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                                        @foreach ($sizes as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ $defaultVariant && $defaultVariant->size_id == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <span>Color</span>
                                    <select id="color-select" name="color"
                                        style="width: 100%; padding: 5px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                                        <option value="" disabled></option>
                                        <!-- Màu sẽ được cập nhật khi chọn size -->
                                    </select>
                                </div>
                            </div>




                            <div class="pro-details-size-content mt-3">
                                <span>Số lượng</span>
                                <div>
                                    <input id="quantity-input" type="number" name="quantity" value="1" min="1"
                                        max="{{ $quantity }}"
                                        style="width: 20%;height: 10%; padding: 5px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; text-align: center;">
                                </div>
                            </div>

                            <div class="pro-details-affiliate default-btn btn-hover" style=" margin-top: 20px;">
                                <button type="submit"
                                    style="
                                    font-size: 14px;
                                    padding: 10px 20px;
                                    border-radius: 5px;
                                    border: none;
                                    background-color: #000;
                                    color: #fff;
                                    cursor: pointer;
                                    transition: background-color 0.3s ease, transform 0.3s ease;
                                    text-transform: uppercase; /* Optional: Uppercase text */
                                "
                                    onmouseover="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';"
                                    onmouseout="this.style.backgroundColor='#000'; this.style.transform='scale(1)';"
                                    onmousedown="this.style.backgroundColor='#444'; this.style.transform='scale(0.95)';"
                                    onmouseup="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';">
                                    Thêm vào Giỏ Hàng
                                </button>
                            </div>

                        </form>








                     


                        <div class="pro-details-meta">
                            <span>Danh mục:</span>
                            <ul>

                                <li><a href="#">{{ $product->category->name }}</a></li>

                                {{-- <li><a href="#">Minimal,</a></li>
                                <li><a href="#">Furniture,</a></li>
                                <li><a href="#">Fashion</a></li> --}}
                            </ul>
                        </div>
                        <div class="pro-details-meta">
                            <span>Mã sản phẩm:</span>
                            <ul>
                                <li><a href="#">{{ $product->sku }} </a></li>

                            </ul>
                        </div>
                        <div class="pro-details-meta">
                            <span>Số lượng:</span>
                            <ul>
                                {{-- <span id="product-quantity">Số lượng: {{ $quantity }}</span> --}}
                                <li><span id="product-quantity">{{ $quantity }}</span>
                                </li>

                            </ul>
                        </div>
                       
                        
                        
                        
                        
                        
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="active" data-bs-toggle="tab" href="#des-details1">Thông tin sản phẩm</a>
                            <a data-bs-toggle="tab" href="#des-details2">Bình Luận</a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane active">
                                <div class="product-description-wrapper">
                                    
                                   
                                        
                                        
                                        <p class="full-description">
                                            {!! $product->description !!} 
                                        </p>
                                       
                                   
                            
                                </div>
                            </div>
                            
                            <!-- CSS Styling -->
                           
                            
                            
                           
                            
                            
                            <!-- CSS for showing/hiding content based on checkbox state -->
                            
                            
                            
                            <div id="des-details2" class="tab-pane ">
                                <div class="review-wrapper">
                                    @foreach ($comments as $comment)
                                        <div class="single-review">
                                            <div class="review-img">
                                                <img src="{{ Storage::url($comment->user->image) }}" alt="User Image">
                                            </div>
                                            <div class="review-content">
                                                <p>{{ $comment->content }}</p>
                                                <div class="review-top-wrap">
                                                    <div class="review-name">
                                                        <h4>{{ $comment->user->name }}</h4>
                                                    </div>
                                                    <div class="review-rating">
                                                        @for ($i = 1; $i <= $comment->rating; $i++)
                                                            <i class="la la-star"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                
                                    <div class="pagination-wrapper">
                                        {{ $comments->links('pagination::bootstrap-5') }}
                                      </div>
                                </div>
                                <div class="ratting-form-wrapper">


                                    <div class="star-box-wrap">
                                        <div class="single-ratting-star" data-rating="1">
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star" data-rating="2">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star" data-rating="3">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star" data-rating="4">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star" data-rating="5">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                    </div>




                                    <div class="ratting-form">
                                        <form action="{{ route('comments.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" id="rating-value" name="rating" value="">

                                            <div class="rating-form-style mb-20">
                                                <label>Nội dung<span>*</span></label>
                                                <textarea name="content" required></textarea>
                                            </div>

                                            <div class="form-submit">
                                                <input type="submit" value="Gửi bình luận">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                               

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="pro-dec-banner">
                        <a href="#"><img src="assets/images/banner/banner-4.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-area pb-100">
        <div class="container">
            <div class="section-title text-center mb-45">
                <h2>Sản phẩm cùng loại</h2>
            </div>
            <div class="row">
                @foreach ($sanpham_cung_loai as $spcl)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="product-wrap product-border-1">
                            <div class="product-img">
                                <a href="{{ route('product.detail', $spcl->slug) }}">
                                    <img src="{{ Storage::url($spcl->img_thumb) }}" alt="product">
                                </a>
                            </div>
                            <div class="product-content product-content-padding text-center">
                                <div class="text-center">


                                    @if ($spcl->variants->isNotEmpty())
                                        @php
                                            $uniqueColors = $spcl->variants
                                                ->pluck('color')
                                                ->filter()
                                                ->unique('hex_code');
                                        @endphp

                                        @foreach ($uniqueColors as $color)
                                            <span
                                                style="background-color: {{ $color->hex_code }}; width: 15px; height: 15px; display: inline-block; border: 1px solid #ccc;border-radius:50%"></span>
                                        @endforeach
                                    @endif
                                </div>
                                <h4><a href="{{ route('product.detail', $spcl->slug) }}">{{ $spcl->name }}</a>
                                </h4>
                                <div class="product-rating">
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                </div>
                                <div class="">
                                    <span style="font-size: 16px">{{ number_format($product->price_min, 0, ',', '.') }} -  </span>
                                    <span style="font-size: 16px">{{ number_format($product->price_max, 0, ',', '.') }} VNĐ </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var productId = "{{ $product->id }}"; // ID sản phẩm

            function updateColors(sizeId) {
                $.ajax({
                    url: '{{ route('product.variant.colors') }}',
                    type: 'GET',
                    data: {
                        size: sizeId,
                        product_id: productId
                    },
                    success: function(response) {
                        var colorSelect = $('#color-select');
                        colorSelect.empty(); // Xóa các tùy chọn hiện tại

                        if (response.success) {
                            $.each(response.colors, function(id, name) {
                                colorSelect.append(new Option(name, id));
                            });

                            colorSelect.prop('disabled', colorSelect.find('option').length === 0);
                            // Kích hoạt hoặc vô hiệu hóa select màu sắc dựa trên số lượng màu có sẵn
                            if (colorSelect.find('option').length === 1) {
                                colorSelect.val(colorSelect.find('option').first().val())
                                    .change(); // Chọn màu đầu tiên và cập nhật giá
                            } else {
                                // Nếu có nhiều màu sắc, giữ giá trị hiện tại
                                if (colorSelect.val()) {
                                    colorSelect.change();
                                }
                            }
                        } else {
                            colorSelect.prop('disabled', true);
                            $('#product-price').text('Không tìm thấy màu sắc cho kích thước đã chọn!');
                            $('#product-old-price').text('Chưa có giá');
                            $('#product-quantity').text('Chưa có số lượng');
                            $('#quantity-input').attr('max', 1);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi cập nhật màu sắc.');
                    }
                });
            }

            function updatePriceAndQuantity(sizeId, colorId) {
                $.ajax({
                    url: '{{ route('product.variant.price') }}',
                    type: 'GET',
                    data: {
                        size: sizeId,
                        color: colorId,
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#product-price').text(response.price_sale + ' VND');
                            $('#product-old-price').text(response.price + ' VND');
                            $('#product-quantity').text(response.quantity);
                            $('#quantity-input').attr('max', response.quantity);
                        } else {
                            $('#product-price').text('Không tìm thấy biến thể phù hợp!');
                            $('#product-old-price').text('Chưa có giá');
                            $('#product-quantity').text('Chưa có số lượng');
                            $('#quantity-input').attr('max', 1);
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra. Vui lòng thử lại!');
                    }
                });
            }

            // Cập nhật màu sắc khi trang được tải lần đầu nếu có kích thước mặc định
            var defaultSizeId = $('#size-select').val();
            if (defaultSizeId) {
                updateColors(defaultSizeId);
            }

            // Cập nhật màu sắc khi người dùng thay đổi kích thước
            $('#size-select').change(function() {
                var sizeId = $(this).val();
                updateColors(sizeId);
            });

            // Cập nhật giá và số lượng khi người dùng thay đổi màu sắc
            $('#color-select').change(function() {
                var sizeId = $('#size-select').val();
                var colorId = $(this).val();

                if (sizeId && colorId) {
                    updatePriceAndQuantity(sizeId, colorId);
                }
            });

            // Gọi hàm change cho color-select để cập nhật giá và số lượng lần đầu nếu có màu sắc mặc định
            var defaultColorId = $('#color-select').val();
            if (defaultColorId) {
                updatePriceAndQuantity(defaultSizeId, defaultColorId);
            }
        });

        document.getElementById('quantity-input').addEventListener('change', function() {
            var max = parseInt(this.max);
            var min = parseInt(this.min);
            var value = parseInt(this.value);

            if (value > max) {
                alert('Số lượng bạn nhập vượt quá số lượng có sẵn!');
                this.value = max;
            }

            if (value < min) {
                alert('Số lượng không thể nhỏ hơn ' + min);
                this.value = min;
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const stars = document.querySelectorAll(".single-ratting-star");
            const ratingValueInput = document.getElementById("rating-value");

            stars.forEach((star, index) => {
                // Lắng nghe sự kiện click
                star.addEventListener("click", function() {
                    const rating = index + 1;
                    ratingValueInput.value = rating;

                    // Reset tất cả các sao (tẩy bỏ màu vàng)
                    stars.forEach(s => s.classList.remove("selected"));

                    // Thêm màu vàng cho các sao từ đầu đến sao đã chọn
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.add("selected");
                    }
                });
            });
        });
    </script>
@endsection
