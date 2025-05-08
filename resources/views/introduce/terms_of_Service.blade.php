@extends('main')

@section('content')
    <div class="container py-5" style="font-size: 16px; max-width: 850px !important; text-align: justify;">
        <div class="text-center mb-5">
            <h2 class="fw-bold"><i class="bi bi-file-earmark-text"></i> {{ __('review.tos_title') }}</h2>
            <p class="text-muted">{{ __('review.tos_subtitle') }}</p>
        </div>

        <div class="card shadow rounded-4 p-4">
            <h4 class="fw-bold mb-3"><i class="bi bi-check2-circle text-primary"></i> {{ __('review.tos_accept_title') }}</h4>
            <p>{{ __('review.tos_accept_content') }}</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-image text-success"></i> {{ __('review.tos_image_title') }}</h4>
            <p>{{ __('review.tos_image_content') }} <a href="{{ route('home.contact_us') }}">{{ __('review.contact_title') }}</a>.</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-shield-lock-fill text-danger"></i>
                {{ __('review.tos_privacy_title') }}</h4>
            <p>{{ __('review.tos_privacy_content') }}</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-exclamation-triangle-fill text-warning"></i>
                {{ __('review.tos_user_title') }}</h4>
            <ul class="list-unstyled">
                <li>{{ __('review.tos_user_1') }}</li>
                <li>{{ __('review.tos_user_2') }}</li>
                <li>{{ __('review.tos_user_3') }}</li>
            </ul>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-journal-check text-info"></i> {{ __('review.tos_change_title') }}
            </h4>
            <p>{{ __('review.tos_change_content') }}</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-question-circle text-secondary"></i>
                {{ __('review.tos_contact_title') }}</h4>
            <p>{{ __('review.tos_contact_content') }} <a
                    href="mailto:photoaigen2210@gmail.com">photoaigen2210@gmail.com</a>.</p>
        </div>
    </div>
@endsection


@section('footer')
@endsection
