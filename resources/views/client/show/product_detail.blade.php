@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url(assets/images/bg/breadcrumb.jpg);">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Product details</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">Product details </li>
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

                        {{-- <div class="product-details-price">
                            <span style="font-size: 16px">{{ number_format($product->price_min, 0, ',', '.') }}
                                VND</span>
                            <span style="font-size: 12px" class="old">{{ number_format($product->price_max, 0, ',', '.') }}
                                VND</span>
                        </div> --}}
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






                        {{-- <div class="pro-details-list">
                        <ul>
                            <li>- 0.5 mm Dail</li>
                            <li>- Inspired vector icons</li>
                            <li>- Very modern style </li>
                        </ul>
                    </div> --}}
                      

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
                                <button type="submit" style="
                                    font-size: 14px;
                                    padding: 10px 20px;
                                    border-radius: 5px;
                                    border: none;
                                    background-color: #000;
                                    color: #fff;
                                    cursor: pointer;
                                    transition: background-color 0.3s ease, transform 0.3s ease;
                                    text-transform: uppercase; /* Optional: Uppercase text */
                                " onmouseover="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';" 
                                onmouseout="this.style.backgroundColor='#000'; this.style.transform='scale(1)';"
                                onmousedown="this.style.backgroundColor='#444'; this.style.transform='scale(0.95)';" 
                                onmouseup="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';">
                                    Thêm vào Giỏ Hàng
                                </button>
                            </div>
                            
                        </form>






                        {{-- <div class="product-details-price">
                            <span id="product-price">{{ $defaultPrice }} VND</span>
                            <span id="product-quantity">Số lượng: {{ $defaultQuantity }}</span>
                        </div> --}}

                        {{-- <div class="pro-details-size-color mt-2">
                            <div class="pro-details-size-content">
                                <span>Size</span>
                                <select id="size-select" name="size" 
                                        style="width: 100%; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                                    @foreach ($sizes as $id => $name)
                                        <option value="{{ $id }}" 
                                                style="padding: 10px; background-color: white; color: #333;">
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                    <div class="pro-details-color-content">
                        <span>Color</span>
                        <div>
                            <select id="color-select" name="color"
                            style="width: 100%; padding: 10px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                                @foreach ($colors as $id => $name)
                                    <option value="{{ $id }}"  style="padding: 10px; background-color: white; color: #333;">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                       
                    </div> --}}


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
                                                    colorSelect.val(colorSelect.find('option').first().val()).change(); // Chọn màu đầu tiên và cập nhật giá
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
                        
                        
                        












                        {{-- <div class="pro-details-size-color">
                            <div class="pro-details-color-wrap" style="overflow: visible">
                                <span>Color</span>
                                <div class="pro-details-color-content mb-5" >
                                    <ul style="list-style-type: none; padding: 0; margin: 0;">
                                        @foreach ($colors as $id => $hexCode)
                                            <li style="display: inline-block; padding: 5px 10px">
                                                <span
                                                    style="background-color: {{ $hexCode }}; width: 15px; height: 15px; display: inline-block; border: 1px solid #ccc; border-radius: 50%;">
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                        <div class="pro-details-size-color mt-2">

                        
                        <div class="pro-details-size">
                            <span>Size</span>
                            <div class="pro-details-size-content" style="margin: 20px 10px">
                                <ul>
                                    @foreach ($sizes as $id => $name)
                                    <li><a href="#">{{$name}}</a></li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    </div> --}}


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
                        <div class="pro-details-meta">
                            <ul>
                                <li>
                                    @if (Str::contains($product->description, '<table'))
                                        <figure class="table" style="margin: 20px 0;">
                                            <table style="width: 100%; border-collapse: collapse;">
                                                {!! str_replace('<td', '<td style="padding: 10px; border: 1px solid #ddd;"', $product->description) !!}
                                            </table>
                                        </figure>
                                    @else
                                        <p style="font-size: 16px; line-height: 1.5; color: #333;">
                                            {!! $product->description !!}
                                        </p>
                                    @endif
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="description-review-area pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="description-review-wrapper">
                        <div class="description-review-topbar nav">
                            <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                            <a data-bs-toggle="tab" href="#des-details3">Additional information</a>
                            <a data-bs-toggle="tab" href="#des-details2">Reviews (3)</a>
                        </div>
                        <div class="tab-content description-review-bottom">
                            <div id="des-details1" class="tab-pane active">
                                <div class="product-description-wrapper">
                                    <p>Pellentesque orci lectus, bibendum iaculis aliquet id, ullamcorper nec ipsum. In
                                        laoreet ligula vitae tristique viverra. Suspendisse augue nunc, laoreet in arcu ut,
                                        vulputate malesuada justo. Donec porttitor elit justo, sed lobortis nulla interdum
                                        et. Sed lobortis sapien ut augue condimentum, eget ullamcorper nibh lobortis. Cras
                                        ut bibendum libero. Quisque in nisl nisl. Mauris vestibulum leo nec pellentesque
                                        sollicitudin.</p>
                                    <p>Pellentesque lacus eros, venenatis in iaculis nec, luctus at eros. Phasellus id
                                        gravida magna. Maecenas fringilla auctor diam consectetur placerat. Suspendisse non
                                        convallis ligula. Aenean sagittis eu erat quis efficitur. Maecenas volutpat erat ac
                                        varius bibendum. Ut tincidunt, sem id tristique commodo, nunc diam suscipit lectus,
                                        vel</p>
                                </div>
                            </div>
                            <div id="des-details3" class="tab-pane">
                                <div class="product-anotherinfo-wrapper">
                                    <ul>
                                        <li><span>Weight</span> 400 g</li>
                                        <li><span>Dimensions</span>10 x 10 x 15 cm </li>
                                        <li><span>Materials</span> 60% cotton, 40% polyester</li>
                                        <li><span>Other Info</span> American heirloom jean shorts pug seitan letterpress
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="des-details2" class="tab-pane">
                                <div class="review-wrapper">
                                    <div class="single-review">
                                        <div class="review-img">
                                            <img src="assets/images/product-details/client-1.jpg" alt="">
                                        </div>
                                        <div class="review-content">
                                            <p>“In convallis nulla et magna congue convallis. Donec eu nunc vel justo
                                                maximus posuere. Sed viverra nunc erat, a efficitur nibh”</p>
                                            <div class="review-top-wrap">
                                                <div class="review-name">
                                                    <h4>Stella McGee</h4>
                                                </div>
                                                <div class="review-rating">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-review">
                                        <div class="review-img">
                                            <img src="assets/images/product-details/client-2.jpg" alt="">
                                        </div>
                                        <div class="review-content">
                                            <p>“In convallis nulla et magna congue convallis. Donec eu nunc vel justo
                                                maximus posuere. Sed viverra nunc erat, a efficitur nibh”</p>
                                            <div class="review-top-wrap">
                                                <div class="review-name">
                                                    <h4>Stella McGee</h4>
                                                </div>
                                                <div class="review-rating">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-review">
                                        <div class="review-img">
                                            <img src="assets/images/product-details/client-3.jpg" alt="">
                                        </div>
                                        <div class="review-content">
                                            <p>“In convallis nulla et magna congue convallis. Donec eu nunc vel justo
                                                maximus posuere. Sed viverra nunc erat, a efficitur nibh”</p>
                                            <div class="review-top-wrap">
                                                <div class="review-name">
                                                    <h4>Stella McGee</h4>
                                                </div>
                                                <div class="review-rating">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ratting-form-wrapper">
                                    <span>Add a Review</span>
                                    <p>Your email address will not be published. Required fields are marked <span>*</span>
                                    </p>
                                    <div class="star-box-wrap">
                                        <div class="single-ratting-star">
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                        <div class="single-ratting-star">
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                            <i class="la la-star"></i>
                                        </div>
                                    </div>
                                    <div class="ratting-form">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-20">
                                                        <label>Your review <span>*</span></label>
                                                        <textarea name="Your Review"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-20">
                                                        <label>Name <span>*</span></label>
                                                        <input type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-20">
                                                        <label>Email <span>*</span></label>
                                                        <input type="email">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-submit">
                                                        <input type="submit" value="Submit">
                                                    </div>
                                                </div>
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
    </div> --}}
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
                                <div class="product-action">
                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View"
                                        href="#">
                                        <i class="la la-plus"></i>
                                    </a>
                                    <a title="Add To Cart" href="#">
                                        <i class="la la-shopping-cart"></i>
                                    </a>
                                    <a title="Wishlist" href="wishlist.html">
                                        <i class="la la-heart-o"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-content product-content-padding text-center">
                                <h4><a href="{{ route('product.detail', $spcl->slug) }}">{{ $spcl->name }}</a>
                                </h4>
                                <div class="product-rating">
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                </div>
                                <div class="product-price">
                                    <span>{{ number_format($spcl->price_sale, 0) }} VNĐ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>




    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="tab-content quickview-big-img">
                                <div id="pro-1" class="tab-pane fade show active">
                                    <img src="assets/images/product/quickview-l1.jpg" alt="">
                                </div>
                                <div id="pro-2" class="tab-pane fade">
                                    <img src="assets/images/product/quickview-l2.jpg" alt="">
                                </div>
                                <div id="pro-3" class="tab-pane fade">
                                    <img src="assets/images/product/quickview-l3.jpg" alt="">
                                </div>
                                <div id="pro-4" class="tab-pane fade">
                                    <img src="assets/images/product/quickview-l2.jpg" alt="">
                                </div>
                            </div>
                            <!-- Thumbnail Large Image End -->
                            <!-- Thumbnail Image End -->
                            <div class="quickview-wrap mt-15">
                                <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                    <a class="active" data-bs-toggle="tab" href="#pro-1"><img
                                            src="assets/images/product/quickview-s1.jpg" alt=""></a>
                                    <a data-bs-toggle="tab" href="#pro-2"><img
                                            src="assets/images/product/quickview-s2.jpg" alt=""></a>
                                    <a data-bs-toggle="tab" href="#pro-3"><img
                                            src="assets/images/product/quickview-s3.jpg" alt=""></a>
                                    <a data-bs-toggle="tab" href="#pro-4"><img
                                            src="assets/images/product/quickview-s2.jpg" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="product-details-content quickview-content">
                                <h2>Products Name Here</h2>
                                <div class="product-details-price">
                                    <span>$18.00 </span>
                                    <span class="old">$20.00 </span>
                                </div>
                                <div class="pro-details-rating-wrap">
                                    <div class="pro-details-rating">
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star-half-o"></i>
                                    </div>
                                    <span>3 Reviews</span>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisic elit eiusm tempor incidid ut labore et
                                    dolore magna aliqua. Ut enim ad minim venialo quis nostrud exercitation ullamco</p>
                                <div class="pro-details-list">
                                    <ul>
                                        <li>- 0.5 mm Dail</li>
                                        <li>- Inspired vector icons</li>
                                        <li>- Very modern style </li>
                                    </ul>
                                </div>
                                <div class="pro-details-size-color">
                                    <div class="pro-details-color-wrap">
                                        <span>Color</span>
                                        <div class="pro-details-color-content">
                                            <ul>
                                                <li class="blue"></li>
                                                <li class="maroon active"></li>
                                                <li class="gray"></li>
                                                <li class="green"></li>
                                                <li class="yellow"></li>
                                                <li class="white"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pro-details-size">
                                        <span>Size</span>
                                        <div class="pro-details-size-content">
                                            <ul>
                                                <li><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li><a href="#">xl</a></li>
                                                <li><a href="#">xxl</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton"
                                            value="2">
                                    </div>
                                    <div class="pro-details-cart btn-hover">
                                        <a href="#">Add To Cart</a>
                                    </div>
                                    <div class="pro-details-wishlist">
                                        <a title="Add To Wishlist" href="#"><i class="la la-heart-o"></i></a>
                                    </div>
                                    <div class="pro-details-compare">
                                        <a title="Add To Compare" href="#"><i class="la la-refresh"></i></a>
                                    </div>
                                </div>
                                <div class="pro-details-meta">
                                    <span>Categories :</span>
                                    <ul>
                                        <li><a href="#">Minimal,</a></li>
                                        <li><a href="#">Furniture,</a></li>
                                        <li><a href="#">Fashion</a></li>
                                    </ul>
                                </div>
                                <div class="pro-details-meta">
                                    <span>Tag :</span>
                                    <ul>
                                        <li><a href="#">Fashion, </a></li>
                                        <li><a href="#">Furniture,</a></li>
                                        <li><a href="#">Electronic</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
