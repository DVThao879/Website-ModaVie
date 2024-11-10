@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>Cửa hàng</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ</a>
                    </li>
                    <li class="active">Cửa hàng </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-area pt-95 pb-100 section-padding-2">
        <div class="container-fluid">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="shop-top-bar">
                        <div class="select-shoing-wrap">
                            <div class="shop-select">
                                <select id="sortBy" onchange="sortProducts()">
                                    <option value=""> Mới nhất </option>
                                    <option value="a_to_z" {{ request('sort') == 'a_to_z' ? 'selected' : '' }}> A đến Z </option>
                                    <option value="z_to_a" {{ request('sort') == 'z_to_a' ? 'selected' : '' }}> Z đến A </option>
                                    <option value="price_low_to_high" {{ request('sort') == 'price_low_to_high' ? 'selected' : '' }}> Giá: thấp đến cao</option>
                                    <option value="price_high_to_low" {{ request('sort') == 'price_high_to_low' ? 'selected' : '' }}> Giá: cao đến thấp</option>
                                </select>
                            </div>
                            
                            <script>
                                function sortProducts() {
                                    const sortValue = document.getElementById('sortBy').value;
                                    const url = new URL(window.location.href);
                                    url.searchParams.set('sort', sortValue); // Thêm hoặc cập nhật tham số 'sort' trong URL
                                    window.location.href = url.toString(); // Điều hướng đến URL mới
                                }
                            </script>
                            
                            
                            <div class="shop-result-info">
                                <p>
                                    Hiển thị
                                    {{ $products->firstItem() }}–{{ $products->lastItem() }} 
                                    trong {{ $products->total() }} kết quả
                                </p>
                            </div>
                                                    </div>
                        <div class="shop-tab nav">
                            <a class="active" href="#shop-1" data-bs-toggle="tab">
                                <i class="la la-th-large"></i>
                            </a>
                            <a href="#shop-2" data-bs-toggle="tab">
                                <i class="la la-reorder"></i>
                            </a>
                        </div>
                    </div>
                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">
                            <div id="shop-1" class="tab-pane active">

                                <div class="row">
                                    @if ($noResults)
                                        <span class="text-center">Không tìm thấy sản phẩm nào phù hợp.</span>
                                    @else
                                       
                                 

                                    @foreach ($products as $sp)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="product-wrap product-border-1 mb-30">
                                                <div class="product-img">
                                                    <a href="{{ route('product.detail', $sp->slug) }}"><img
                                                            src="{{ Storage::url($sp->img_thumb) }}" alt="product"></a>



                                                    {{-- <div class="product-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                        <a title="Add To Cart" href="#"><i
                                                                class="la la-shopping-cart"></i></a>
                                                        <a title="Wishlist" href="wishlist.html"><i
                                                                class="la la-heart-o"></i></a>
                                                    </div> --}}
                                                </div>
                                                <div class="product-content product-content-padding text-center">
                                                    <div class="text-center">


                                                        @if ($sp->variants->isNotEmpty())
                                                            @php
                                                                $uniqueColors = $sp->variants
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
                                                    <h4><a
                                                            href="{{ route('product.detail', $sp->slug) }}">{{ $sp->name }}</a>
                                                    </h4>
                                                    <div class="product-rating">
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                    </div>
                                                    <div class="">
                                                        <span
                                                            style="font-size: 16px">{{ number_format($sp->price_min, 0, ',', '.') }}
                                                            -
                                                        </span>

                                                        <span style="font-size: 16px"
                                                            class="">{{ number_format($sp->price_max, 0, ',', '.') }}
                                                            VNĐ</span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="product-wrap product-border-1 mb-30">
                                        <div class="product-img">
                                            <a href="product-details.html"><img src="assets/images/product/hm1-pro-2.jpg" alt="product"></a>
                                            <div class="product-action">
                                                <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                <a title="Add To Cart" href="#"><i class="la la-shopping-cart"></i></a>
                                                <a title="Wishlist" href="wishlist.html"><i class="la la-heart-o"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content product-content-padding text-center">
                                            <h4><a href="product-details.html">Demo Product Name</a></h4>
                                            <div class="product-rating">
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star-half-o"></i>
                                                <i class="la la-star-half-o"></i>
                                            </div>
                                            <div class="product-price">
                                                <span>£210.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="pro-pagination-style text-center mt-20">
                                    <ul>
                                        @if ($products->onFirstPage())
                                            <li><a class="prev disabled" href="#"><i class="la la-angle-left"></i></a></li>
                                        @else
                                            <li><a class="prev" href="{{ $products->previousPageUrl() }}"><i
                                                        class="la la-angle-left"></i></a></li>
                                        @endif
        
                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <li>
                                                <a class="{{ $i == $products->currentPage() ? 'active' : '' }}"
                                                    href="{{ $products->url($i) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor
        
                                        @if ($products->hasMorePages())
                                            <li><a class="next" href="{{ $products->nextPageUrl() }}"><i
                                                        class="la la-angle-right"></i></a></li>
                                        @else
                                            <li><a class="next disabled" href="#"><i class="la la-angle-right"></i></a></li>
                                        @endif
                                    </ul>
                                </div>

                                @endif
                                </div>
                            </div>
                            {{-- <div id="shop-2" class="tab-pane ">
                            <div class="shop-list-wrap mb-30">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6">
                                        <div class="product-wrap product-border-1">
                                            <div class="product-img">
                                                <a href="#">
                                                    <img src="assets/images/product/hm1-pro-1.jpg" alt="product">
                                                </a>
                                                <span class="product-badge">-30%</span>
                                                <div class="product-action">
                                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6">
                                        <div class="shop-list-content">
                                            <h3><a href="#">Products Name Here</a></h3>
                                            <div class="product-list-rating">
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                            </div>
                                            <div class="product-list-price">
                                                <span>$ 60.00</span>
                                                <span class="old">$ 90.00</span>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit. </p>
                                            <div class="shop-list-btn-wrap">
                                                <div class="shop-list-cart default-btn btn-hover">
                                                    <a href="#">ADD TO CART</a>
                                                </div>
                                                <div class="shop-list-wishlist default-btn btn-hover">
                                                    <a href="#"><i class="la la-heart-o"></i></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-list-wrap mb-30">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6">
                                        <div class="product-wrap product-border-1">
                                            <div class="product-img">
                                                <a href="#">
                                                    <img src="assets/images/product/hm1-pro-2.jpg" alt="product">
                                                </a>
                                                <div class="product-action">
                                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6">
                                        <div class="shop-list-content">
                                            <h3><a href="#">Products Name Here</a></h3>
                                            <div class="product-list-rating">
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star-half-o"></i>
                                            </div>
                                            <div class="product-list-price">
                                                <span>$ 60.00</span>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit. </p>
                                            <div class="shop-list-btn-wrap">
                                                <div class="shop-list-cart default-btn btn-hover">
                                                    <a href="#">ADD TO CART</a>
                                                </div>
                                                <div class="shop-list-wishlist default-btn btn-hover">
                                                    <a href="#"><i class="la la-heart-o"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-list-wrap mb-30">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6">
                                        <div class="product-wrap product-border-1">
                                            <div class="product-img">
                                                <a href="#">
                                                    <img src="assets/images/product/hm1-pro-3.jpg" alt="product">
                                                </a>
                                                <span class="product-badge">-30%</span>
                                                <div class="product-action">
                                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6">
                                        <div class="shop-list-content">
                                            <h3><a href="#">Products Name Here</a></h3>
                                            <div class="product-list-rating">
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                            </div>
                                            <div class="product-list-price">
                                                <span>$ 60.00</span>
                                                <span class="old">$ 90.00</span>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit. </p>
                                            <div class="shop-list-btn-wrap">
                                                <div class="shop-list-cart default-btn btn-hover">
                                                    <a href="#">ADD TO CART</a>
                                                </div>
                                                <div class="shop-list-wishlist default-btn btn-hover">
                                                    <a href="#"><i class="la la-heart-o"></i></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shop-list-wrap mb-30">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6">
                                        <div class="product-wrap product-border-1">
                                            <div class="product-img">
                                                <a href="#">
                                                    <img src="assets/images/product/hm1-pro-4.jpg" alt="product">
                                                </a>
                                                <div class="product-action">
                                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6">
                                        <div class="shop-list-content">
                                            <h3><a href="#">Products Name Here</a></h3>
                                            <div class="product-list-rating">
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                                <i class="la la-star"></i>
                                            </div>
                                            <div class="product-list-price">
                                                <span>$ 250.00</span>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit. </p>
                                            <div class="shop-list-btn-wrap">
                                                <div class="shop-list-cart default-btn btn-hover">
                                                    <a href="#">ADD TO CART</a>
                                                </div>
                                                <div class="shop-list-wishlist default-btn btn-hover">
                                                    <a href="#"><i class="la la-heart-o"></i></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        </div>


                        {{-- <div class="">
                            {{ $products->links('pagination::bootstrap-5') }}
                          </div> --}}

                      

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sidebar-style mr-30">
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">Tìm kiếm</h4>
                            <div class="pro-sidebar-search mb-50 mt-25">
                                <form class="pro-sidebar-search-form" action="{{ route('product.search') }}"
                                    method="GET">
                                    <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..."
                                        value="{{ request('keyword') }}">
                                    <button type="submit">
                                        <i class="la la-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                       
                        
                        
                        
                        
                        <div class="sidebar-widget mt-50">
                            <h4 class="pro-sidebar-title">Danh mục</h4>
                            <div class="sidebar-widget-tag mt-25">
                                <ul>
                                    <li><a href="{{ route('shop') }}">Tất cả <span>({{ $totalproducts }})</span></a></li>
                                    @foreach ($categories as $dm)
                                        {{-- <li><a href="#">Clothing</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">For Men</a></li>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Fashion</a></li> --}}
                                        <li><a href="{{ route('shop.categories', $dm->id) }}">{{ $dm->name }}
                                                <span>({{ $dm->products_count }})</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
