@extends('main')

@section('content')
    <div class="bg-news ">
        <div class="breadcrumb-option spad pt-2">
            <div class="container">
                <div class="">
                    <div class="col-lg-12 p-0">
                        <div class="bo-links">
                            <a href="/blog"><i class="fa fa-home"></i> Home</a>
                            <i class="bi bi-chevron-right"></i>
                            <span>Blog</span>

                            @if (isset($danhmuc->name))
                                <i class="bi bi-chevron-double-right"></i>
                                <span>{{ $danhmuc->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-start container pad-catagory align-items-center">
            <div class="catagory">
                <span>{{ __('messages.News_category') }}:</span>
            </div>
            <div class="btn-group catagory-btn" role="group" aria-label="Button group with nested dropdown">
                {{-- <!-- Nút phổ biến -->
                <a href="/blog/popular" class="btn btn-primary rounded btn-link-a">{{ __('messages.Blog_popular') }}</a> --}}
                <a href="/blog/popular"
                    class="neon-button mr-2 d-flex align-items-center">{{ __('messages.Blog_popular') }}</a>

                <!-- Dropdown thể loại -->
                <div class="btn-group" role="group">
                    <button type="button" class="neon-button dropdown-toggle d-flex align-items-center"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('messages.category') }}
                    </button>
                    <ul class="list-categories dropdown-menu">
                        {{-- Tạo danh sách danh mục ảnh --}}
                        @foreach ($danhmucs as $item)
                            <li>
                                <a class="dropdown-item text-dark" href="/blog/category/{{ $item->id }}">
                                    {{ $item->translated_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <section class="blog-section ">
            <div class="container">
                <div class="d-flex flex-wrap">
                    <div class="col-lg-9">
                        @foreach ($lists as $blog)
                            <a href="/blog/blogdetail/{{ $blog->id }}">
                                <div class="blog-item">
                                    <div class="bi-pic">
                                        <img src="{{ $blog->first_image_url ?? '/upload/hinhdaidien/default.png' }}"
                                            onerror="this.onerror=null;this.src='/upload/hinhdaidien/default.png';"
                                            alt="Ảnh minh họa">
                                    </div>

                                    <div class="bi-text text-justify mr-3">
                                        <div class="label">{{ $blog->category->name ?? 'Uncategorized' }}</div>
                                        <h5>
                                            {{ Str::limit($blog->translated_title, 50) }}
                                        </h5>
                                        <ul>
                                            <li>by <span>{{ $blog->author->name ?? 'Admin' }}</span></li>
                                            <li>{{ $blog->created_at->format('M d, Y') }}</li>
                                            <li>{{ number_format($blog->view_fake, 0, ',', '.') }} {{ __('messages.view') }}</li>
                                            @if (Auth::check() && Auth::user()->role_id == 0)
                                                <li>{{ number_format($blog->view, 0, ',', '.') ?? 0 }} View real</li>
                                            @endif
                                        </ul>
                                        <p>{{ Str::limit($blog->translated_description, 180) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        <div class="blog-pagination">
                            @include('admin.page')
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="blog-sidebar">
                            <!-- Danh sách bài viết khác -->
                            <div class="bs-item s-mb">
                                <h5>{{ __('messages.Other_articles') }}</h5>
                                <div class="bi-feature-post">
                                    @foreach ($blogs_random as $blog)
                                        <a href="/blog/blogdetail/{{ $blog->id }}" class="fp-item">
                                            <div class="fp-pic">
                                                <img src="{{ $blog->first_image_url ?? '/upload/hinhdaidien/default.png' }}"
                                                    onerror="this.onerror=null;this.src='/upload/hinhdaidien/default.png';"
                                                    alt="Ảnh minh họa">
                                            </div>
                                            <div class="fp-text text-justify">
                                                <h6>{{ Str::limit($blog->translated_title, 20) }}</h6>
                                                <span>{{ $blog->created_at->format('M, d, Y') }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <hr>
                            {{-- Chèn quảng cáo --}}
                            <div class="bs-item">
                                <h5>Instagram</h5>
                                <div class="bi-insta">
                                    <img src="/template/img/blog/insta-1.jpg" alt="Instagram 1">
                                    <img src="/template/img/blog/insta-2.jpg" alt="Instagram 2">
                                    <img src="/template/img/blog/insta-3.jpg" alt="Instagram 3">
                                    <img src="/template/img/blog/insta-4.jpg" alt="Instagram 4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
