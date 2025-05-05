@extends('main')

@section('content')
    <section class="portfolio-section spad">
        <div class="container">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>{{ __('messages.search_results') }}</h2>
                </div>
                {{-- danh mục --}}
                {{-- <div class="category-list filter-controls">
                    <ul>
                        <li class="active" data-filter="*" danhmuc-filter="*">All</li>
                        @foreach ($danhmucs as $danhmuc)
                            <li data-filter=".{{ Str::slug($danhmuc->name) }}"
                                danhmuc-filter="{{ Str::slug($danhmuc->name) }}">{{ $danhmuc->name }}</li>
                        @endforeach
                    </ul>
                </div> --}}
            </div>
        </div>

        {{-- List ảnh --}}
        <div class="grid-images" id="grid-images" data-total-images="{{ $totalImages }}" data-url="{{ route('home.search') }}">
            <div class="grid-wrapper" id="image-list">
                @if ($lists->isEmpty())
                    <p>{{ __('messages.no_search') }}</p>
                @else
                    @include('list_image.list_image', ['images' => $lists])
                @endif
            </div>
        </div>

        @include('admin.page')
    </section>
@endsection

@section('footer')
    <script src="/template/js/design.js"></script>
@endsection
