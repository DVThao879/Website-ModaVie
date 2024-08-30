@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url(assets/images/bg/breadcrumb.jpg);">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>shop page</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">shop list full wide </li>
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
                                <select>
                                    <option value="">Sort by newness</option>
                                    <option value="">A to Z</option>
                                    <option value=""> Z to A</option>
                                    <option value="">In stock</option>
                                </select>
                            </div>
                            <p>Showing 1–12 of 20 result</p>
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
                                    @foreach ($products as $sp)
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                            <div class="product-wrap product-border-1 mb-30">
                                                <div class="product-img">
                                                    <a href="{{route('user.product.detail',$sp->slug)}}"><img
                                                            src="{{ Storage::url($sp->img_thumb) }}" alt="product"></a>
                                                   
                                        
                                                   
                                                    <div class="product-action">
                                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            title="Quick View" href="#"><i class="la la-plus"></i></a>
                                                        <a title="Add To Cart" href="#"><i
                                                                class="la la-shopping-cart"></i></a>
                                                        <a title="Wishlist" href="wishlist.html"><i
                                                                class="la la-heart-o"></i></a>
                                                    </div>
                                                </div>
                                                <div class="product-content product-content-padding text-center">
                                                    <div class="text-center" >


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
                                                    <h4><a href="product-details.html">{{ $sp->name }}</a></h4>
                                                    <div class="product-rating">
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                        <i class="la la-star"></i>
                                                    </div>
                                                    <div class="">
                                                        <span
                                                            style="font-size: 16px">{{ number_format($sp->price_sale, 0, ',', '.') }} -
                                                            </span>
                                                            @if($sp->price>$sp->price_sale)
                                                        <span style="font-size: 16px"
                                                            class="">{{ number_format($sp->price, 0, ',', '.') }}
                                                            VNĐ</span>
                                                            @endif
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
                        <div class="pro-pagination-style text-center mt-20">
                            <ul>
                                <li><a class="prev" href="#"><i class="la la-angle-left"></i></a></li>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a class="next" href="#"><i class="la la-angle-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sidebar-style mr-30">
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">Search </h4>
                            <div class="pro-sidebar-search mb-50 mt-25">
                                <form class="pro-sidebar-search-form" action="#">
                                    <input type="text" placeholder="Search here...">
                                    <button>
                                        <i class="la la-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">Refine By </h4>
                            <div class="sidebar-widget-list mt-30">
                                <ul>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox"> <a href="#">On Sale <span>4</span> </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">New <span>5</span></a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">In Stock <span>6</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-45">
                            <h4 class="pro-sidebar-title">Filter By Price </h4>
                            <div class="price-filter mt-10">
                                <div class="price-slider-amount">
                                    <input type="text" id="amount" name="price" placeholder="Add Your Price" />
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-50">
                            <h4 class="pro-sidebar-title">Colour </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">Green <span>7</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">Cream <span>8</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">Blue <span>9</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">Black <span>3</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-40">
                            <h4 class="pro-sidebar-title">Size </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">XL <span>4</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">L <span>5</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">SM <span>6</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sidebar-widget-list-left">
                                            <input type="checkbox" value=""> <a href="#">XXL <span>7</span>
                                            </a>
                                            <span class="checkmark"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mt-50">
                            <h4 class="pro-sidebar-title">Tag </h4>
                            <div class="sidebar-widget-tag mt-25">
                                <ul>
                                    <li><a href="">Tất cả <span>({{ $totalproducts }})</span></a></li>
                                    @foreach ($categories as $dm)
                                        {{-- <li><a href="#">Clothing</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">For Men</a></li>
                                <li><a href="#">Women</a></li>
                                <li><a href="#">Fashion</a></li> --}}
                                        <li><a href="{{route('user.shop.categories',$dm->id)}}">{{ $dm->name }}
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
