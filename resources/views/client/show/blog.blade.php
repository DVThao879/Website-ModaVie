@extends('client.layouts.app')

@section('content')
    <div class="breadcrumb-area pt-95 pb-100 bg-img"
        style="background-image:url('/theme/client/assets/images/bg/breadcrumb.jpg');">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <div class="breadcrumb-title">
                    <h2>blog page</h2>
                </div>
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="active">blog </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="blog-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach ($blogs as $blog)
                            <div class="col-lg-4 col-md-6">
                                <div class="blog-wrap mb-30">
                                    <div class="blog-img mb-15" style="width: 100%; height: 200px; overflow: hidden;">
                                        <a href="{{ route('article.detail', $blog->id) }}">
                                            <img alt="" src="{{ Storage::url($blog->img_avt) }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>
                                    </div>

                                    <div class="blog-content text-center">

                                        <h3
                                            style="font-size: 18px; line-height: 1.4; font-weight: bold; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                            <a href="blog-details.html"
                                                style="text-decoration: none; color: inherit;">{{ $blog->title }}</a>
                                        </h3>
                                        <div class="blog-meta">
                                            <a href="#"><i class="la la-user"></i>{{ $blog->user->name }}</a>
                                            <a href="#"><i class="la la-clock-o"></i>
                                                {{ $blog->created_at->format('d/m/Y') }}</a>
                                        </div>

                                        <div class="blog-btn" style="text-align: center; margin-top: 15px;">
                                            <a href="{{ route('article.detail', $blog->id) }}"
                                                style="display: inline-block;padding: 10px 20px;background-color: #FF6347;color: white;font-size: 16px;font-weight: bold;
                                        text-align: center;text-decoration: none;border-radius: 25px;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);transition: all 0.3s ease-in-out;">
                                                Xem</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pro-pagination-style text-center mt-20 pagination-mrg-xs-none">
                        <ul>
                            <li><a class="prev" href="#"><i class="la la-angle-left"></i></a></li>
                            <li><a class="active" href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a class="next" href="#"><i class="la la-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
