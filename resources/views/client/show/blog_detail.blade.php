@extends('client.layouts.app')
@section('content')
<div class="breadcrumb-area pt-95 pb-100 bg-img" style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <div class="breadcrumb-title">
                <h2>Chi tiết bài viết</h2>
            </div>
            <ul>
                <li>
                    <a href="index.html">Trang chủ</a>
                </li>
                <li class="active">Chi tiết bài viết</li>
            </ul>
        </div>
    </div>
</div>
<div class="blog-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="blog-details-wrapper ml-20">
                    <div class="blog-details-top">
                        <div class="blog-details-img mb-20">
                            <img alt="" src="{{Storage::url($blog->img_avt)}}">
                        </div>
                        <div class="blog-details-content">
                            <h3>{{$blog->title}}</h3>
                            <div class="blog-dec-meta">
                                <span><i class="la la-user"></i> {{$blog->user->name}}</span>
                                <span><i class="la la-clock-o"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                                <span><i class="la la-eye"></i> {{$blog->view}}</span>
                                
                            </div>
                            <p>{!! $blog->content !!}</p>
                             @if($voucher)
                               <p>Mã giảm giá: <strong>{{$voucher->code }}</strong> ( còn {{ \Carbon\Carbon::parse($voucher->start_date)->diffInDays(\Carbon\Carbon::parse($voucher->end_date)) }} ngày) </p>
                               <p>Giảm <strong>{{$voucher->discount}} % </strong> cho đơn hàng từ <strong>{{ number_format($voucher->min_money, 0, ',', '.') }} VND</strong>  đến <strong>{{ number_format($voucher->max_money, 0, ',', '.') }} VND</strong>   </p>
                              
                               @endif
                        </div>
                    </div>
                    <div class="next-previous-post mt-50">
                        @if($previousBlog)
                            <a href="{{ route('article.detail', $previousBlog->id) }}">
                                <i class="la la-angle-left"></i> Trang trước
                            </a>
                        @endif
                        @if($nextBlog)
                            <a href="{{ route('article.detail', $nextBlog->id) }}">
                                Trang sau <i class="la la-angle-right"></i>
                            </a>
                        @endif
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sidebar-style">
                   
                    <div class="sidebar-widget mt-40">
                        <h4 class="pro-sidebar-title">Gần đây </h4>
                        <div class="sidebar-project-wrap mt-30">
                            @foreach($recentBlogs as $recent)
                            <div class="single-sidebar-blog">
                              
                                <div class="sidebar-blog-img">
                                    <a href="{{route('article.detail',$recent->id)}}"><img src="{{Storage::url($recent->img_avt)}}" alt=""></a>
                                </div>
                                <div class="sidebar-blog-content">
                                    <span>{{$recent->user->name}}</span>
                                    <h4><a href="{{route('article.detail',$recent->id)}}">{{ \Illuminate\Support\Str::limit($recent->title, 10, '...') }}</a></h4>
                                </div>
                                
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-20">
                            <a href="{{ route('article') }}" class="btn btn-circle">
                                <i class="la la-arrow-right"></i> Xem tất cả 
                            </a>
                        </div>
                    </div>
                    
                   
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection