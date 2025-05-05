<section class="categories-section">
    <div class="box-category">
        <div class="section-title">
            {{-- <h2>Danh mục ảnh</h2> --}}
        </div>
        <div class="categories-slider owl-carousel rounded">
            @foreach ($danhmucs as $danhmuc)
                <a href="/images-categories/{{ $danhmuc->id }}">
                    <div class="cs-item shadow pb-3 rounded-top ">
                        <div class="cs-pic set-bg rounded"
                            data-setbg="{{ isset($danhmuc->images) && $danhmuc->images->first()?->full_url ? asset($danhmuc->images->first()->full_url) : asset('/upload/default/default.jpg') }}">
                        </div>
                        
                        <div class="cs-text">
                            <h4>{{ $danhmuc->translated_name }}</h4>
                            <span>{{ $danhmuc->images_count }} pictures</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
