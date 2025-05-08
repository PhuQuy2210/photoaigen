@extends('main')

@section('content')
    <div class="box-category_child">
        <div class="breadcrumb-option pl-2">
            <div class="bo-links">
                <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                <i class="bi bi-chevron-right"></i>
                <span>{{ $danhmucID->translated_name }}</span>
            </div>
        </div>
        @include('category_images.list_category')

        <h2 class="pb-2 pl-2 fw-bold text-uppercase bg-h2">
            {{ __('messages.explore_more') }}
        </h2>
        @foreach ($danhmuccons as $danhmuc)
            <div class="category_child btn-group mt-3 pl-2" role="group">
                <a href="{{ route('images.categoriesChild', ['id' => $danhmuc->id]) }}"
                    class="btn btn-custom">{{ $danhmuc->translated_name }}</a>
            </div>
        @endforeach
    </div>
    <section class="portfolio-section pt-5">
        <div class="category-name ps-2 pb-3">
            <h2 class="bg-h2 pl-2">{{ __('messages.categories') }}: {{ $danhmucID->translated_name }}</h2>
        </div>

        {{-- List ảnh --}}
        <div class="grid-images" id="grid-images" data-total-images="{{ $totalImages }}" data-url="{{ route('home') }}">
            <div class="grid-wrapper" id="image-list">
                @include('list_image.list_image')
            </div>
        </div>

        @include('admin.page')
    </section>
@endsection
@section('footer')
    <script src="{{ asset('template/js/design.js') }}"></script>
@endsection
