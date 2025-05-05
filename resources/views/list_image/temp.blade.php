@php
    $images = [
        ['src' => '/template/img/portfolio/pf-0.jpg', 'name' => 'ảnh 0', 'chieu' => 'ngang', 'type'=>'Lifestyle'],
        ['src' => '/template/img/portfolio/pf-1.jpg', 'name' => 'ảnh 1', 'chieu' => 'doc', 'type'=>'Wedding'],
        ['src' => '/template/img/portfolio/pf-3.jpg', 'name' => 'ảnh 3', 'chieu' => 'doc', 'type'=>'Fashion'],
        ['src' => '/template/img/portfolio/pf-2.jpg', 'name' => 'ảnh 2', 'chieu' => 'ngang', 'type'=>'Lifestyle'],
        ['src' => '/template/img/portfolio/pf-5.jpg', 'name' => 'ảnh 5', 'chieu' => 'doc', 'type'=>''],
        ['src' => '/template/img/portfolio/pf-4.jpg', 'name' => 'ảnh 4', 'chieu' => 'ngang', 'type'=>'Lifestyle'],
        ['src' => '/template/img/portfolio/pf-7.jpg', 'name' => 'ảnh 7', 'chieu' => 'doc', 'type'=>'Lifestyle'],
        ['src' => '/template/img/portfolio/pf-6.jpg', 'name' => 'ảnh 6', 'chieu' => 'ngang', 'type'=>'Natural'],
        ['src' => '/template/img/portfolio/pf-10.jpg', 'name' => 'ảnh 10', 'chieu' => 'ngang', 'type'=>'Natural'],
        ['src' => '/template/img/portfolio/pf-8.jpg', 'name' => 'ảnh 8', 'chieu' => 'ngang', 'type'=>'Natural'],
        ['src' => '/template/img/portfolio/pf-9.jpg', 'name' => 'ảnh 9', 'chieu' => 'doc', 'type'=>'Videos'],
        ['src' => '/template/img/portfolio/pf-11.jpg', 'name' => 'ảnh 11', 'chieu' => 'doc', 'type'=>'Videos'],
        ['src' => '/template/img/portfolio/pf-13.jpg', 'name' => 'ảnh 13', 'chieu' => 'doc', 'type'=>'Videos'],
        ['src' => '/template/img/portfolio/pf-12.jpg', 'name' => 'ảnh 12', 'chieu' => 'ngang', 'type'=>'Lifestyle'],
        ['src' => '/template/img/portfolio/pf-14.jpg', 'name' => 'ảnh 14', 'chieu' => 'ngang', 'type'=>'Wedding'],
        ['src' => '/template/img/portfolio/pf-16.jpg', 'name' => 'ảnh 16', 'chieu' => 'ngang', 'type'=>'Wedding'],
        ['src' => '/template/img/portfolio/pf-15.jpg', 'name' => 'ảnh 15', 'chieu' => 'doc', 'type'=>'Lifestyle'],
    ];

@endphp


<section class="portfolio-section spad">
    {{-- danh mục --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Our latest works</h2>
                </div>
                <div class="filter-controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".Fashion">Fashion</li>
                        <li data-filter=".Lifestyle">Lifestyle</li>
                        <li data-filter=".Natural">Natural</li>
                        <li data-filter=".Wedding">Wedding</li>
                        <li data-filter=".Videos">Videos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    {{-- List ảnh --}}
    <div class="grid-images">
        <div class="grid-wrapper">
            @foreach ($images as $image)
                <div class="item_image {{ $image['type'] }} {{ $image['chieu'] === 'ngang' ? 'ngang' : 'doc' }}">
                    <!-- Ảnh chính -->
                    <img class="if" src="{{ $image['src'] }}" alt="{{ $image['name'] }}">
                    <div class="box-icon">
                        <!-- Nút tải ảnh -->
                        <div class="download-icon position-absolute top-0 start-0" title="Tải ảnh">
                            <a href="{{ $image['src'] }}" download>
                                {{-- <img src="/template/img/icon/download.jpg" alt="download"> --}}
                                <i class="bi bi-download"></i>
                                <span>Tải ảnh</span>
                            </a>
                        </div>
        
                        <!-- Nút lượt xem -->
                        <div class="view-icon position-absolute start-0 " title="Lượt xem">
                            <i class="bi bi-eye"></i>
                            <span>123</span>
                        </div>
        
                        <!-- Nút thích -->
                        <div class="like-icon position-absolute top-0 end-0" title="Thích ảnh">
                            <i class="bi bi-heart"></i>
                            <span>123</span>
                        </div>
                    </div>
    
                    <!-- Nút mở rộng -->
                    <a href="{{ $image['src'] }}" class="pf-icon position-absolute image-popup" title="Mở rộng">
                        <span class="icon_plus"></span>
                    </a>
    
                    <!-- Tiêu đề ảnh -->
                    <div class="pf-text">
                        <h4>{{ $image['name'] }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- load more --}}
    <div class="load-more-btn">
        <a href="#">Load More</a>
    </div>
</section>


