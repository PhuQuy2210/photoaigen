@extends('main')

@section('content')
    <div class="container py-5 " style="font-size: 16px; max-width: 850px !important; text-align: justify;">
        <div class="text-center mb-5" >
            <h2 class="fw-bold"><i class="bi bi-shield-lock-fill"></i> {{ __('review.privacy_title') }}</h2>
            <p class="text-muted">{{ __('review.privacy_subtitle') }}</p>
        </div>

        <div class="card shadow rounded-4 p-4">
            <h4 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary"></i> {{ __('review.privacy_collect_title') }}
            </h4>
            <p>{{ __('review.privacy_collect_content') }}</p>
            <ul class="list-unstyled">
                <li>{{ __('review.privacy_collect_1') }}</li>
                <li>{{ __('review.privacy_collect_2') }}</li>
                <li>{{ __('review.privacy_collect_3') }}</li>
            </ul>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-lock text-success"></i> {{ __('review.privacy_use_title') }}</h4>
            <p>{{ __('review.privacy_use_content') }}</p>
            <ul class="list-unstyled">
                <li>{{ __('review.privacy_use_1') }}</li>
                <li>{{ __('review.privacy_use_2') }}</li>
                <li>{{ __('review.privacy_use_3') }}</li>
            </ul>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-file-earmark-lock2 text-warning"></i>
                {{ __('review.privacy_protect_title') }}</h4>
            <p>{{ __('review.privacy_protect_content') }}</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-people-fill text-danger"></i>
                {{ __('review.privacy_share_title') }}</h4>
            <p>{!! __('review.privacy_share_content') !!}</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-person-check text-secondary"></i>
                {{ __('review.privacy_rights_title') }}</h4>
            <p>{{ __('review.privacy_rights_content') }}</p>
            <ul class="list-unstyled">
                <li>{{ __('review.privacy_rights_1') }}</li>
                <li>{{ __('review.privacy_rights_2') }}</li>
            </ul>
            <p>{{ __('review.privacy_rights_footer') }} <a href="/contact_us">tại đây</a>.</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-arrow-clockwise text-info"></i>
                {{ __('review.privacy_change_title') }}</h4>
            <p>{{ __('review.privacy_change_content') }}</p>

            <h4 class="fw-bold mt-5 mb-3"><i class="bi bi-envelope-fill text-primary"></i>
                {{ __('review.privacy_contact_title') }}</h4>
            <p>{{ __('review.privacy_contact_content') }} <a
                    href="mailto:photoaigen2210@gmail.com">photoaigen2210@gmail.com</a></p>
        </div>
    </div>
@endsection


@section('footer')
@endsection
