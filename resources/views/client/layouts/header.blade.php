<header class="header-area sticky-bar transparent-bar">
    <div class="main-header-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-2 col-lg-2">
                    <div class="logo">
                        <a href="{{ route('home') }}" class="fw-bold fs-3 text-info">MODAVIE
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li><a href="{{route('home')}}">Trang chủ </a>
                                </li>
                                <li><a href="{{route('shop')}}">Cửa hàng </a>
                                </li>
                                <li><a href="{{route('article')}}">Tin tức</a>
                                </li>
                                <li><a href="shop.html">Liên hệ </a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2">
                    <div class="header-right-wrap">
                        <div class="same-style cart-wrap">
                            <a href="#" class="cart-active">
                                <i class="la la-shopping-cart"></i>
                                <span class="count-style">
                                    @if(session('cart'))
                                        {{-- Đếm số loại sản phẩm trong giỏ hàng --}}
                                        {{ count(session('cart')) }}
                                    @else
                                        0
                                    @endif
                                </span>
                                
                                
                            </a>
                        </div>
                        
                        <div class="same-style header-search ml-15">
                            <a class="search-active" href="javascript:void(0);"><i class="la la-search"></i></a>
                        </div>
                        
                        <div class="same-style setting-wrap ml-15">
                            <a class="setting-active" href="#">
                                <img class="profile-image" src="{{ Auth::check() ? Storage::url(Auth::user()->image ?? 'users/avata.jpg') : Storage::url('users/avata.jpg') }}" alt="">
                            </a>
                            <div class="setting-content">
                                <ul>

                                    <li>
                                        <a href="">
                                            <h4>Tài Khoản</h4>
                                        </a>
                                    </li>

                                    <li>
                                        <ul>
                                            @if(Auth::check())
                                                {{-- <h4>Tài khoản</h4> --}}
                                                <li><a href="">Xin chào,
                                                    {{ Auth::user()->name }}</a>
                                                </li>
                                                    <li><a href="{{ route('my_acount') }}">Xem thông tin</a></li>
                                                    @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                                                     <li><a href="{{ route('admin.dashboard') }}">Quản trị viên</a></li>
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('logout') }}">Đăng xuất</a>
                                                    </li>
                                                    
                                            @else
                                                <li><a href="{{ route('login')}}">Đăng nhập</a></li>
                                                <li><a href="{{ route('register') }}">Đăng ký</a></li>
                                                <li><a href="{{ route('bill.search')}}">Tra cứu đơn hàng</a></li>
                                            @endif
                                        </ul>
                                    </li>

                                    

                                   
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-small-mobile">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        <a href="index.html">
                            <img alt="" src="assets/images/logo/logo.png">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        <div class="same-style cart-wrap">
                            <a href="#" class="cart-active">
                                <i class="la la-shopping-cart"></i>
                                <span class="count-style">02</span>
                            </a>
                        </div>
                        <div class="same-style mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="la la-navicon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="mobile-off-canvas-active">
    <a class="mobile-aside-close"><i class="la la-close"></i></a>
    <div class="header-mobile-aside-wrap">
        <div class="mobile-search">
            <form class="search-form" action="#">
                <input type="text" placeholder="Search entire store…">
                <button class="button-search"><i class="la la-search"></i></button>
            </form>
        </div>
        <div class="mobile-menu-wrap">
            <!-- mobile menu start -->
            <div class="mobile-navigation">
                <!-- mobile menu navigation start -->
                <nav>
                    <ul class="mobile-menu">
                        <li class="menu-item-has-children"><a href="index.html">Home</a>
                            <ul class="dropdown">
                                <li><a href="index.html">Home version 1 </a></li>
                                <li><a href="index-2.html">Home version 2 </a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children "><a href="shop.html">shop</a>
                            <ul class="dropdown">
                                <li class="menu-item-has-children"><a href="#">Shop Layout</a>
                                    <ul class="dropdown">
                                        <li><a href="shop.html">standard style</a></li>
                                        <li><a href="shop-2col.html">grid 2 column</a></li>
                                        <li><a href="shop-right-sidebar.html">grid right sidebar</a></li>
                                        <li><a href="shop-grid-no-sidebar.html">grid no sidebar</a></li>
                                        <li><a href="shop-grid-fw.html">grid full wide</a></li>
                                        <li><a href="shop-list.html">list 1 column</a></li>
                                        <li><a href="shop-list-fw-2col.html">list 2 column</a></li>
                                        <li><a href="shop-list-fw.html">list full wide</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children"><a href="#">products details</a>
                                    <ul class="dropdown">
                                        <li><a href="product-details.html">tab style 1</a></li>
                                        <li><a href="product-details-tab-2.html">tab style 2</a></li>
                                        <li><a href="product-details-tab-3.html">tab style 3</a></li>
                                        <li><a href="product-details-gallery.html">gallery style </a></li>
                                        <li><a href="product-details-sticky.html">sticky style</a></li>
                                        <li><a href="product-details-sticky-right.html">sticky right</a></li>
                                        <li><a href="product-details-slider-box.html">slider style</a></li>
                                        <li><a href="product-details-affiliate.html">Affiliate style</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="shop.html">Accessories </a></li>
                        <li class="menu-item-has-children"><a href="#">pages</a>
                            <ul class="dropdown">
                                <li><a href="about-us.html">about us </a></li>
                                <li><a href="cart.html">cart page </a></li>
                                <li><a href="checkout.html">checkout </a></li>
                                <li><a href="compare.html">compare </a></li>
                                <li><a href="wishlist.html">wishlist </a></li>
                                <li><a href="my-account.html">my account </a></li>
                                <li><a href="contact.html">contact us </a></li>
                                <li><a href="login-register.html">login/register </a></li>
                                <li><a href="404.html">404 page </a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children "><a href="blog.html">Blog</a>
                            <ul class="dropdown">
                                <li><a href="blog.html">standard style </a></li>
                                <li><a href="blog-no-sidebar.html"> blog no sidebar </a></li>
                                <li><a href="blog-right-sidebar.html">blog right sidebar</a></li>
                                <li><a href="blog-details.html">blog details</a></li>
                            </ul>
                        </li>
                        <li><a href="contact-us.html">Contact us</a></li>
                    </ul>
                </nav>
                <!-- mobile menu navigation end -->
            </div>
            <!-- mobile menu end -->
        </div>
        <div class="mobile-curr-lang-wrap">
            <div class="single-mobile-curr-lang">
                <a class="mobile-language-active" href="#">Language <i class="la la-angle-down"></i></a>
                <div class="lang-curr-dropdown lang-dropdown-active">
                    <ul>
                        <li><a href="#">English (US)</a></li>
                        <li><a href="#">English (UK)</a></li>
                        <li><a href="#">Spanish</a></li>
                    </ul>
                </div>
            </div>
            <div class="single-mobile-curr-lang">
                <a class="mobile-currency-active" href="#">Currency <i class="la la-angle-down"></i></a>
                <div class="lang-curr-dropdown curr-dropdown-active">
                    <ul>
                        <li><a href="#">USD</a></li>
                        <li><a href="#">EUR</a></li>
                        <li><a href="#">Real</a></li>
                        <li><a href="#">BDT</a></li>
                    </ul>
                </div>
            </div>
            <div class="single-mobile-curr-lang">
                <a class="mobile-account-active" href="#">My Account <i class="la la-angle-down"></i></a>
                <div class="lang-curr-dropdown account-dropdown-active">
                    <ul>
                        <li><a href="login-register.html">Login</a></li>
                        <li><a href="login-register.html">Creat Account</a></li>
                        <li><a href="my-account.html">My Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="quick-info">
            <ul>
                <li><i class="la la-phone"></i> +012 456 789</li>
                <li> <i class="la la-envelope"></i> <a href="#">INFO@EXAMPLE.COM</a></li>
                <li> <i class="la la-clock-o"></i> MON-SAT:8AM TO 9PM</li>
            </ul>
        </div>
    </div>
</div>
<!-- search start -->
<div class="search-content-wrap main-search-active">
    <a class="search-close"><i class="la la-close"></i></a>
    <div class="search-content">
        <p>Start typing and press Enter to search</p>
        <form class="search-form" action="#">
            <input type="text" placeholder="Search entire store…">
            <button class="button-search"><i class="la la-search"></i></button>
        </form>
    </div>
</div>
<!-- mini cart start -->
<div class="sidebar-cart-active">
    <div class="sidebar-cart-all">
        <a class="cart-close" href="#"><i class="la la-close"></i></a>
        <div class="cart-content">
            <h3>Shopping Cart</h3>
            <ul>
                <li class="single-product-cart">
                    <div class="cart-img">
                        <a href="#"><img src="assets/images/cart/cart-1.jpg" alt=""></a>
                    </div>
                    <div class="cart-title">
                        <h4><a href="#"> Flower Dress </a></h4>
                        <span>1 × £54.00</span>
                    </div>
                    <div class="cart-delete">
                        <a href="#">×</a>
                    </div>
                </li>
                <li class="single-product-cart">
                    <div class="cart-img">
                        <a href="#"><img src="assets/images/cart/cart-2.jpg" alt=""></a>
                    </div>
                    <div class="cart-title">
                        <h4><a href="#">Ruffled cotton top</a></h4>
                        <span>1 × £54.00</span>
                    </div>
                    <div class="cart-delete">
                        <a href="#">×</a>
                    </div>
                </li>
            </ul>
            <div class="cart-total">
                <h4>Subtotal: <span>£ 108.00</span></h4>
            </div>
            <div class="cart-checkout-btn btn-hover default-btn">
                <a class="btn-size-md btn-bg-black btn-color" href="cart.html">view cart</a>
                <a class="no-mrg btn-size-md btn-bg-black btn-color" href="checkout.html">checkout</a>
            </div>
        </div>
    </div>
</div>