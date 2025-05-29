@foreach ($lists as $image)
    <div class="item_image {{ Str::slug($image->category->name) }} {{ $image->direction == '0' ? 'ngang' : 'doc' }}"
        data-id="{{ $image->id }}">
        <img class="if" src="{{ asset($image->full_thumb) }}" alt="{{ __('messages.image_alt') }}">
        <div class="box-icon">
            <div class="download-icon position-absolute top-0 start-0" title="{{ __('messages.download_image') }}">
                <a href="{{ route('download.image', ['url' => $image->full_url]) }}">
                    <i class="bi bi-download"></i>
                    <span>{{ __('messages.download_image') }}</span>
                </a>
            </div>
            @if (Auth::check() && Auth::user()->role_id == 0)
                <div class="view-icon position-absolute start-0" title="{{ __('messages.view_count') }}">
                    <i class="bi bi-eye"></i>
                    <span>{{ number_format($image->view_real, 0, ',', '.') }}</span>
                </div>
            @else
                @php
                    if (!function_exists('formatViews')) {
                        function formatViews($views)
                        {
                            if ($views >= 1000) {
                                return rtrim(number_format($views / 1000, 1), '.0') . 'k';
                            }
                            return number_format($views, 0, ',', '.');
                        }
                    }
                @endphp

                <div class="view-icon position-absolute start-0" title="{{ __('messages.view_count') }}">
                    <i class="bi bi-eye"></i>
                    <span>{{ formatViews($image->view) }}</span>
                </div>
            @endif
            <div class="like-icon position-absolute top-0 end-0" title="{{ __('messages.like_image') }}"
                onclick="handleLike({{ $image->id }}, this)">
                <i class="bi {{ $image->userHasLiked ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                <span>{{ number_format($image->like_count, 0, ',', '.') }}</span>
            </div>
            @if (Auth::check() && Auth::user()->role_id == 0)
                <div class="report-icon position-absolute top-0 start-0" title="{{ __('messages.report_violation') }}">
                    <a href="javascript:void(0);"
                        onclick="handleCheckLogin('{{ Auth::check() }}', '{{ $image->id }}')">
                        <i class="bi bi-chat-left-text"></i>
                    </a>
                </div>
            @else
                <div class="report-icon position-absolute top-0 start-0" title="{{ __('messages.report_violation') }}"
                    style="bottom: 0px !important;">
                    <a href="javascript:void(0);"
                        onclick="handleCheckLogin('{{ Auth::check() }}', '{{ $image->id }}')">
                        <i class="bi bi-chat-left-text"></i>
                    </a>
                </div>
            @endif
        </div>
        <a href="{{ asset($image->full_url) }}" class="pf-icon position-absolute image-popup"
            title="{{ __('messages.expand_image') }}">
            <i class="bi bi-arrows-fullscreen"></i>
        </a>

        <div class="pf-text d-flex justify-content-center align-items-center">
            @if (Auth::check() && Auth::user()->role_id == 0)
                <h4>{{ $image->category->name }}</h4>
                <i class="bi bi-dash m-1"></i>
                <h4>{{ $image->id }}</h4>
            @endif
        </div>
    </div>
@endforeach
<script>
    window.loginMessages = {
        not_logged_in: @json(__('messages.not_logged_in')),
        login_required_message: @json(__('messages.login_required_message')),
        login_with_google: @json(__('messages.login_with_google')),
        cancel: @json(__('messages.cancel')),
    };
</script>
{{-- <script>
    function formatViews(views) {
        if (views >= 1000) {
            return (views / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
        }
        return views.toLocaleString('de-DE');
    }
</script> --}}
