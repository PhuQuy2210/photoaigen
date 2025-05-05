@extends('main')
@section('head')
    <style>
        .about_us .card {
            background-color: #ffffff;
            border-radius: 1rem;
        }

        .about_us .card h1,
        .about_us .card h3 {
            color: #333;
        }

        .about_us .card ul li {
            font-size: 1rem;
            margin-bottom: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5 about_us " style="font-size: 16px; max-width: 850px !important; text-align: justify;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg rounded-4 border-0 p-4">
                    <h1 class="text-center mb-4 display-5 fw-bold">{{ __('review.title') }}</h1>
                    <p class="lead text-muted text-center mb-4">{{ __('review.subtitle') }}</p>

                    <hr>

                    <section class="mb-4">
                        <h3 class="fw-semibold mb-3"><i class="bi bi-lightbulb"></i> {{ __('review.purpose_title') }}</h3>
                        <p>{{ __('review.purpose_text') }}</p>
                    </section>

                    <section class="mb-4">
                        <h3 class="fw-semibold mb-3"><i class="bi bi-image"></i> {{ __('review.source_title') }}</h3>
                        <p>{{ __('review.source_text') }}</p>
                    </section>

                    <section class="mb-4">
                        <h3 class="fw-semibold mb-3"><i class="bi bi-heart-pulse"></i> {{ __('review.features_title') }}
                        </h3>
                        <ul class="list-unstyled ms-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('review.features.0') }}</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('review.features.1') }}</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('review.features.2') }}</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>{{ __('review.features.3') }}</li>
                        </ul>
                    </section>

                    <section class="mb-4">
                        <h3 class="fw-semibold mb-3"><i class="bi bi-person-check"></i> {{ __('review.users_title') }}</h3>
                        <p>{{ __('review.users_text') }}</p>
                    </section>

                    <section class="mb-4">
                        <h3 class="fw-semibold mb-3"><i class="bi bi-shield-check"></i> {{ __('review.copyright_title') }}
                        </h3>
                        <p>{{ __('review.copyright_text') }}</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
