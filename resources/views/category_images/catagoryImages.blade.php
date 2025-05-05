@extends('main')

@section('content')
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
                                danhmuc-filter="{{ Str::slug($danhmuc->name) }}">{{  $danhmuc->translated_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- List ảnh --}}
        <div class="grid-images" id="grid-images" data-total-images="{{ $totalImages }}">
            <div class="grid-wrapper">
                @include('list_image.list_image')
            </div>
        </div>
        @include('admin.page')
    </section>
@endsection
@section('footer')
    <script src="/template/js/design.js"></script>
@endsection
