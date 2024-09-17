<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Request::is('admin/categories*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/categories*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Quản lí danh mục</span>
        </a>
        <div id="collapseTwo" class="collapse {{ Request::is('admin/categories*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item {{ Request::routeIs('admin.categories.index') ? 'active' : '' }}" href="{{route('admin.categories.index')}}">Danh sách</a>
                <a class="collapse-item {{ Request::routeIs('admin.categories.create') ? 'active' : '' }}" href="{{route('admin.categories.create')}}">Thêm</a>   
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ Request::is('admin/products*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/products*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Quản lí sản phẩm</span>
        </a>
        <div id="collapseUtilities" class="collapse {{ Request::is('admin/products*') ? 'show' : '' }}" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item {{ Request::routeIs('admin.products.index') ? 'active' : '' }}" href="{{route('admin.products.index')}}">Danh sách</a>
                <a class="collapse-item {{ Request::routeIs('admin.products.create') ? 'active' : '' }}" href="{{route('admin.products.create')}}">Thêm</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ Request::is('admin/colors*') || Request::is('admin/sizes*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/colors*') || Request::is('admin/sizes*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseAttributes"
           aria-expanded="true" aria-controls="collapseAttributes">
            <i class="fas fa-fw fa-tags"></i>
            <span>Quản lý thuộc tính</span>
        </a>
        <div id="collapseAttributes" class="collapse {{ Request::is('admin/colors*') || Request::is('admin/sizes*') ? 'show' : '' }}" aria-labelledby="headingAttributes"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item {{ Request::routeIs('admin.colors.index') ? 'active' : '' }}" href="{{ route('admin.colors.index') }}">Danh sách màu sắc</a>
                <a class="collapse-item {{ Request::routeIs('admin.colors.create') ? 'active' : '' }}" href="{{ route('admin.colors.create') }}">Thêm màu sắc</a>
                <a class="collapse-item {{ Request::routeIs('admin.sizes.index') ? 'active' : '' }}" href="{{ route('admin.sizes.index') }}">Danh sách kích thước</a>
                <a class="collapse-item {{ Request::routeIs('admin.sizes.create') ? 'active' : '' }}" href="{{ route('admin.sizes.create') }}">Thêm kích thước</a>
            </div>
        </div>
    </li>
    
    @if (Auth::user()->role == 2)
    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/users*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseAccounts"
           aria-expanded="true" aria-controls="collapseAccounts">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Quản lí tài khoản</span>
        </a>
        <div id="collapseAccounts" class="collapse {{ Request::is('admin/users*') ? 'show' : '' }}" aria-labelledby="headingAccounts"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item {{ Request::routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Danh sách</a>
            </div>
        </div>
    </li>   
    @endif 

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Request::is('admin/banners*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/banners*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapsePages"
           aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Quản lí banner</span>
        </a>
        <div id="collapsePages" class="collapse {{ Request::is('admin/banners*') ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item {{ Request::routeIs('admin.banners.index') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">Danh sách</a>
                <a class="collapse-item {{ Request::routeIs('admin.banners.create') ? 'active' : '' }}" href="{{ route('admin.banners.create') }}">Thêm</a>
                {{-- <a class="collapse-item" href="#">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="#">404 Page</a>
                <a class="collapse-item" href="#">Blank Page</a> --}}
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBanners"
           aria-expanded="true" aria-controls="collapseBanners">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Quản lí khuyến mại</span>
        </a>
        <div id="collapseBanners" class="collapse" aria-labelledby="headingBanners" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh sách chức năng:</h6>
                <a class="collapse-item" href="">Danh sách</a>
                <a class="collapse-item" href="">Thêm</a>
                {{-- {{ route('admin.promotions.index') }}
                {{ route('admin.promotions.create') }} --}}
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Quản lí khuyến mại</span></a>
    </li> --}}

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-table"></i>
            <span>Đơn hàng</span></a>
            {{-- {{ route('admin.orders.index') }} --}}
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="{{ asset('theme/admin/img/undraw_rocket.svg') }}" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div>

</ul>