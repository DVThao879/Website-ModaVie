@extends('client.layouts.app')
@section('content')

<div class="slider-area section-padding-1">
    <div class="slider-active owl-carousel nav-style-1">
        @foreach($banners as $banner)
        <div class="single-slider slider-height-1 bg-paleturquoise">
           
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="slider-single-img-2 slider-animated-2">
                            
                            <img class="animated" src="{{Storage::url($banner->image)}}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6 align-self-center">
                        <div class="slider-content-2 slider-animated-2 text-center">
                            <h3 class="animated">New</h3>
                            <h1 class="animated">{{$banner->title}}</h1>
                            <h4 class="animated">{{$banner->description}}</h4>
                            <div class="slider-btn default-btn btn-hover">
                                <a class="animated btn-size-md btn-bg-black btn-color" href="{{$banner->link}}">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        @endforeach
    </div>
</div>


<div class="feature-area pt-30 pb-65">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="feature-wrap mb-30">
                    <div class="feature-img">
                        <img src="{{asset('theme/client/assets/images/icon-img/feature-1.png')}}" alt="">
                    </div>
                    <div class="feature-content">
                        <h5>MIỄN PHÍ VẬN CHUYỂN</h5>
                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="feature-wrap mb-30">
                    <div class="feature-img">
                        <img src="{{asset('theme/client/assets/images/icon-img/feature-2.png')}}" alt="">
                    </div>
                    <div class="feature-content">
                        <h5>HỖ TRỢ TRỰC TUYẾN</h5>
                        <p>Hỗ trợ trực tuyến 24 giờ một ngày</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="feature-wrap mb-30">
                    <div class="feature-img">
                        <img src="{{asset('theme/client/assets/images/icon-img/feature-3.png')}}" alt="">
                    </div>
                    <div class="feature-content">
                        <h5>HOÀN TIỀN</h5>
                        <p>Đảm bảo hoàn tiền trong vòng 5 ngày</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="product-area pb-70">
    <div class="container">
        <div class="section-title text-center mb-45">
            <h2>Sản Phẩm</h2>
            <p>Sản phẩm đảm bảo chất lượng , giá thành hợp lý</p>
            </div>
        <div class="product-tab-list nav pb-50 text-center">
            <a class="active" href="#product-1" data-bs-toggle="tab">
                <h4>Mới nhất </h4>
            </a>
            <a  href="#product-2" data-bs-toggle="tab">
                <h4>Bán chạy nhất</h4>
            </a>
            <a href="#product-3" data-bs-toggle="tab">
                <h4>Xem nhiều nhất</h4>
            </a>
        </div>
        <div class="tab-content jump">
            <div id="product-1" class="tab-pane active">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="product-wrap product-border-1 mb-30">
                                <div class="product-img">
                                    <a href="{{route('product.detail',$product->slug)}}"><img src="{{Storage::url($product->img_thumb)}}" alt="product"></a>
                                    <span class="product-badge">New</span>
                                </div>
                                <div class="product-content product-content-padding text-center">
                                    <div class="text-center">
                                        @if ($product->variants->isNotEmpty())
                                            @php
                                                $uniqueColors = $product->variants
                                                    ->pluck('color')
                                                    ->filter()
                                                    ->unique('hex_code');
                                            @endphp
                                            @foreach ($uniqueColors as $color)
                                                <span style="background-color: {{ $color->hex_code }}; width: 15px; height: 15px; display: inline-block; border: 1px solid #ccc;border-radius:50%"></span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <h4><a href="{{route('product.detail',$product->slug)}}">{{$product->name}}</a></h4>
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
            
            <div id="product-2" class="tab-pane ">
                <div class="row">
                    @foreach($bestSellingProducts as $productBest)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="product-wrap product-border-1 mb-30">
                            <div class="product-img">
                                <a href="{{ route('product.detail', $productBest->product->slug) }}">
                                    <img src="{{ Storage::url($productBest->product->img_thumb) }}" alt="product">
                                </a>
                                @if($productBest->discount_percentage)
                                    <span class="product-badge">-{{ $productBest->discount_percentage }}%</span>
                                @endif
                            </div>
                            <div class="product-content product-content-padding text-center">
                                <div class="text-center">
                                    @if ($productBest->color)
                                        <span
                                            style="background-color: {{ $productBest->color->hex_code }}; width: 15px; height: 15px; display: inline-block; border: 1px solid #ccc; border-radius:50%">
                                        </span>
                                    @endif
                                </div>
                                <h4><a href="{{ route('product.detail', ['slug' => $productBest->product->slug]) }}">{{ $productBest->product->name }}</a></h4>
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
            
            
            
            <div id="product-3" class="tab-pane">
                <div class="row">
                    @foreach($productView as $prView)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                       
                        <div class="product-wrap product-border-1 mb-30">
                            <div class="product-img">
                                <a href="{{route('product.detail',$prView->slug)}}"><img src="{{Storage::url($prView->img_thumb)}}" alt="product"></a>
                                {{-- <span class="product-badge">-30%</span> --}}
                                {{-- <div class="product-action">
                                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" title="Quick View" href="#"><i class="la la-plus"></i></a>
                                    <a title="Add To Cart" href="#"><i class="la la-shopping-cart"></i></a>
                                    <a title="Wishlist" href="wishlist.html"><i class="la la-heart-o"></i></a>
                                </div> --}}
                            </div>
                            <div class="product-content product-content-padding text-center">
                                <div class="text-center" >


                                    @if ($product->variants && $product->variants->isNotEmpty())
                                    @php
                                        $uniqueColors = $product->variants
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
                                <h4><a href="{{route('product.detail',$prView->slug)}}">{{$prView->name}}</a></h4>
                                <div class="product-rating">
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                </div>
                                <div class="">
                                    <span style="font-size: 16px">{{ number_format($prView->price_min, 0, ',', '.') }} -  </span>
                                    <span style="font-size: 16px">{{ number_format($prView->price_max, 0, ',', '.') }} VNĐ </span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    @endforeach
                   
                </div>
            </div>
            <div class="slider-btn default-btn btn-hover text-center">
                <a style="padding: 10px 15px" class="animated  btn-bg-black btn-color" href="{{route('shop')}}">Xem Tất Cả</a>
            </div>
            
        </div>
    </div>
</div>

<div class="deal-area-2">
    <div class="container">
        <div class="deal-area bg-img pt-100 pb-100" style="background-image:url({{asset('theme/client/assets/images/bg/bg-1.jpg')}});">
            <div class="row">
                <div class="col-lg-6">
                    <div class="deal-content text-center">
                        <h3>Sale 30%</h3>
                        <h2>Big Weekend Sale</h2>
                        <div class="timer">
                            <div data-countdown="2024/01/01"></div>
                        </div>
                        <div class="deal-btn default-btn btn-hover">
                            <a class="btn-size-xs btn-bg-theme btn-color black-color" href="#">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blog-area pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center mb-45">
            <h2>Tin Tức</h2>
            {{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> --}}
        </div>
        <div class="row">
            @foreach($articles as $bl)
            <div class="col-lg-4 col-md-6">
                <div class="blog-wrap mb-30">
                    <div class="blog-img mb-15">
                        <a href="{{route('article.detail',$bl->id)}}"><img alt="" src="{{Storage::url($bl->img_avt)}}"></a>
                    </div>
                    <div class="blog-content text-center">
                        {{-- <div class="blog-category">
                            <a href="#">Fashion</a>
                        </div> --}}
                        <h3><a href="{{route('article.detail',$bl->id)}}">{{$bl->title}}</a></h3>
                        <div class="blog-meta">
                            <a href="{{route('article.detail',$bl->id)}}"><i class="la la-user"></i>{{$bl->user->name}}</a>
                            <a href=""><i class="la la-clock-o"></i> {{ $bl->created_at->format('d/m/Y') }}</a>
                        </div>
                    </div>
                </div>
            </div>
           @endforeach
        </div>
        <div class="slider-btn default-btn btn-hover text-center">
            <a style="padding: 10px 15px" class="animated  btn-bg-black btn-color" href="{{route('article')}}">Xem Thêm</a>
        </div>
    </div>
</div>
<div class="brand-logo-area pb-100">
    <div class="container">
        <div class="brand-logo-active owl-carousel">
            <div class="single-brand-logo">
                <img src="assets/images/brand-logo/barnd-logo-1.png" alt="">
            </div>
            <div class="single-brand-logo">
                <img src="assets/images/brand-logo/barnd-logo-2.png" alt="">
            </div>
            <div class="single-brand-logo">
                <img src="assets/images/brand-logo/barnd-logo-3.png" alt="">
            </div>
            <div class="single-brand-logo">
                <img src="assets/images/brand-logo/barnd-logo-4.png" alt="">
            </div>
            <div class="single-brand-logo">
                <img src="assets/images/brand-logo/barnd-logo-5.png" alt="">
            </div>
        </div>
    </div>
</div>
@endsection