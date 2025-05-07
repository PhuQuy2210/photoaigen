@extends('main')

@section('content')
    <!-- danh mục ảnh -->
    @include('category_images.list_category')

    <section class="portfolio-section spad">
        <div class="container">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>{{ __('messages.category_current_page') }}</h2>
                </div>
                {{-- danh mục --}}
                <div class="category-list filter-controls">
                    <ul>
                        <li class="active" data-filter="*" danhmuc-filter="*">All</li>
                        @foreach ($danhmucs as $danhmuc)
                            <li data-filter=".{{ Str::slug($danhmuc->name) }}"
                                danhmuc-filter="{{ Str::slug($danhmuc->name) }}">{{ $danhmuc->translated_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- List ảnh --}}
        <div class="grid-images" id="grid-images" data-total-images="{{ $totalImages }}" data-url="{{ route('home') }}">
            <div class="grid-wrapper" id="image-list">
                @include('list_image.list_image')
            </div>
        </div>

        @include('pageSearch')
    </section>

@endsection

