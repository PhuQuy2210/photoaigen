@extends('main')

@section('content')
    <!-- Blog Details Section Begin -->
    <div class="blog-hero bg-cover bg-center h-96"
        style="background-image: url('{{ asset($blog->first_image_url ?? 'upload/hinhdaidien/default.png') }}')"></div>
    <section class="blog-details-section py-12">
        <div class="container mx-auto">
            <div class="flex flex-wrap -mx-4">
                <div class="col-lg-12">
                    <div class="blog-details-text">
                        <div class="bd-title mb-6">
                            <div class="bt-bread text-gray-500 text-sm mb-4">
                                <a href="{{ route('blog.index') }}" class="hover:underline"><i class="fa fa-home"></i>
                                    Home</a>
                                <i class="bi bi-chevron-right mx-2"></i>
                                <span>{{ $danhmuc->translated_name }}</span>
                                <i class="bi bi-chevron-double-right mx-2"></i>
                                <span>{{ Str::limit($blog->translated_title, 30) }}</span>
                            </div>
                            <h2 class="text-3xl font-bold mb-4">{{ $blog->translated_title }}</h2>
                            <ul class="flex space-x-4 text-gray-600 text-sm">
                                <li>by <span>{{ $blog->author->name ?? 'Admin' }}</span></li>
                                <li>{{ $blog->created_at->format('M, d, Y') }}</li>
                            </ul>
                        </div>
                        <div class="bd-top-text mb-6">
                            <p class="text-gray-700">{{ $blog->translated_description }}</p>
                        </div>

                        <div class="bd-last-desc mb-6">
                            <p class="text-gray-700">{!! $blog->translated_content !!}</p>
                        </div>

                        {{-- Danh sách ảnh --}}
                        @if ($blogImages->isNotEmpty())
                            <div class="bd-gallery">
                                @foreach ($blogImages as $image)
                                    <div class="item_image position-relative">
                                        <img src="{{ asset($image->full_url) }}" loading="lazy"
                                            onerror="this.onerror=null;this.src='{{ asset('upload/hinhdaidien/default.png') }}';"
                                            alt="Ảnh bài viết" class="preview-img">

                                        <!-- Nút download -->
                                        <div class="download-icon" title="{{ __('messages.download_image') }}">
                                            <a href="{{ route('download.image', ['url' => $image->full_url]) }}">
                                                <i class="bi bi-download"></i>
                                                <span>{{ __('messages.download_image') }}</span>
                                            </a>
                                        </div>

                                        <!-- Nút mở rộng -->
                                        <div class="expand-icon position-absolute top-0 end-0" title="Xem lớn"
                                            data-image="{{ $image->full_url }}">
                                            <i class="bi bi-arrows-fullscreen fs-4"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Không có ảnh</p>
                        @endif


                        <!-- Overlay hiển thị ảnh full màn hình -->
                        <div id="imageOverlay" style="display: none;" class="image-overlay">
                            <span class="close-overlay">✕</span>
                            <img src="" alt="Expanded Image" id="overlayImg">
                        </div>


                        {{-- Chèn quảng cáo --}}
                        <div class="bd-pics">
                            <img src="{{ asset('template/img/blog/details/bd-1.jpg') }}" alt="">
                            <img src="{{ asset('template/img/blog/details/bd-2.jpg') }}" alt="">
                            <img src="{{ asset('template/img/blog/details/bd-3.jpg') }}" alt="">
                        </div>
                        <div class="bd-tag-share flex justify-between items-center mb-6 align-items-center">
                            @php
                                $currentUrl = request()->fullUrl();
                            @endphp

                            <div class="share d-flex justify-between align-items-center">
                                <span class="font-semibold mr-1">{{ __('messages.share') }}:</span>

                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($currentUrl) }}"
                                    target="_blank" rel="noopener" class="facebook text-blue-600 hover:text-blue-800 mb-0">
                                    <i class="fa fa-facebook"></i>
                                </a>

                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($currentUrl) }}" target="_blank"
                                    rel="noopener" class="twitter text-blue-400 hover:text-blue-600 mb-0">
                                    <i class="fa fa-twitter"></i>
                                </a>

                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($currentUrl) }}"
                                    target="_blank" rel="noopener"
                                    class="linkedin text-blue-700 hover:text-blue-900 bg-dark mb-0">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </div>
                            <div class="position-relative d-inline-block ">
                                <button id="copyLinkBtn" class="btn btn-outline-dark d-flex align-items-center gap-2">
                                    <i class="bi bi-link-45deg"></i> <span
                                        class="ml-2">{{ __('messages.copylink') }}</span>
                                </button>
                                <div id="copyTooltip">{{ __('messages.copied') }}</div>
                            </div>
                        </div>

                        <div class="bd-tag-share flex justify-between items-center mb-6">
                            <!-- Thể loại -->
                            <div class="tags flex space-x-2 flex-wrap mb-0">
                                @foreach ($danhmucs as $dm)
                                    <a href="{{ route('blog.category', ['id' => $dm->id]) }}"
                                        class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300 mb-0 inline-block mb-2">
                                        {{ $dm->translated_name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bài viết liên quan -->
                        <section class="blog-section py-12">
                            <div class="container p-0">
                                <div class=" flex flex-wrap -mx-4">
                                    @foreach ($blogs as $item)
                                        <div class="pad-10-resp col-lg-12 p-0">
                                            <div class="blog-item flex flex-col sm:flex-row mb-6 text-justify d-flex">
                                                <div class="bi-pic w-full sm:w-1/3 mb-4 sm:mb-0 col-6 pl-0">
                                                    <img src="{{ asset($blog->first_image_url ?? 'upload/hinhdaidien/default.png') }}"
                                                        onerror="this.onerror=null;this.src='{{ asset('upload/hinhdaidien/default.png') }}';"
                                                        alt="Ảnh minh họa" class="w-full h-48 object-cover rounded-lg">
                                                </div>
                                                <div class="bi-text w-full sm:w-2/3 sm:pl-6 col-6 pr-0">
                                                    <div
                                                        class="label bg-blue-600 text-white px-2 py-1 rounded text-sm mb-2">
                                                        {{ $item->category->translated_name ?? 'Chưa phân loại' }}
                                                    </div>
                                                    <h5 class="text-xl font-semibold mb-2">
                                                        <a href="{{ route('blog.detail', ['id' => $blog->id]) }}"
                                                            class="hover:underline">
                                                            {{ \Illuminate\Support\Str::limit($item->translated_title, 50) }}
                                                        </a>
                                                    </h5>
                                                    <ul class="flex space-x-4 text-gray-600 text-sm mb-2">
                                                        <li>by <span>{{ $item->author->name ?? 'Admin' }}</span></li>
                                                        <li>{{ $item->created_at->format('M d, Y') }}</li>
                                                        <li>{{ number_format($blog->view_fake, 0, ',', '.') ?? 0 }} View
                                                        </li>
                                                        @if (Auth::check() && Auth::user()->role_id == 0)
                                                            <li>{{ number_format($blog->view, 0, ',', '.') ?? 0 }} View
                                                                real</li>
                                                        @endif
                                                    </ul>
                                                    <p class="text-gray-700">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->translated_description), 80) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>

                        <!-- Thông tin tác giả -->
                        <div class="bd-author flex flex-col sm:flex-row items-center bg-gray-50 p-6 rounded-lg">
                            <div class="avatar-pic w-24 h-24 mb-4 sm:mb-0 sm:mr-6">
                                <img src="{{ asset('upload/hinhdaidien/default.png') }}" alt="Avatar"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                            <div class="avatar-text">
                                <h4 class="text-xl font-semibold mb-2">PhotoAIGen</h4>
                                <p class="text-gray-700 mb-2">{{ __('messages.welcome_message') }}</p>
                                <p class="text-gray-700">{{ __('messages.thank_you_message') }}</p>
                                <div class="at-social flex space-x-4 mt-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-800"><i
                                            class="fa fa-facebook"></i></a>
                                    <a href="#" class="text-blue-400 hover:text-blue-600"><i
                                            class="fa fa-twitter"></i></a>
                                    <a href="#" class="text-red-600 hover:text-red-800"><i
                                            class="fa fa-google-plus"></i></a>
                                    <a href="#" class="text-pink-600 hover:text-pink-800"><i
                                            class="fa fa-instagram"></i></a>
                                    <a href="#" class="text-red-600 hover:text-red-800"><i
                                            class="fa fa-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection
@section('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('imageOverlay');
            const overlayImg = document.getElementById('overlayImg');
            const closeBtn = document.querySelector('.close-overlay');

            document.querySelectorAll('.expand-icon').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const imageUrl = this.getAttribute('data-image');
                    overlayImg.src = imageUrl;
                    overlay.style.display = 'flex';
                });
            });

            closeBtn.addEventListener('click', function() {
                overlay.style.display = 'none';
                overlayImg.src = '';
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const copyBtn = document.getElementById("copyLinkBtn");
            const tooltip = document.getElementById("copyTooltip");
            const linkToCopy = "{{ $currentUrl }}"; // Laravel route hiện tại

            copyBtn.addEventListener("click", async () => {
                try {
                    await navigator.clipboard.writeText(linkToCopy);
                    tooltip.classList.add("show");

                    setTimeout(() => {
                        tooltip.classList.remove("show");
                    }, 2000);
                } catch (err) {
                    alert("Không thể sao chép liên kết.");
                }
            });
        });
    </script>
@endsection
