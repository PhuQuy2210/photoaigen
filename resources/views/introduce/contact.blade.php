@extends('main')

@section('content')
    <div class="container py-5" style="font-size: 16px; displaymax-width: 850px !important; text-align: justify;">
        <h2 class="text-center mb-4"><i class="bi bi-telephone-forward"></i> {{ __('review.contact_title') }}</h2>
        <p class="text-center text-muted mb-5">
            {{ __('review.contact_subtitle') }}
        </p>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4 p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-4 d-flex align-items-start">
                            <i class="mr-2 bi bi-geo-alt-fill fs-4 me-3 text-primary"></i>
                            <div>
                                <strong>{{ __('review.contact_address_label') }}</strong><br>
                                Số 18, ngõ 4, Trần Duy Hưng, Cầu Giấy, Hà Nội
                            </div>
                        </li>
                        <li class="mb-4 d-flex align-items-start">
                            <i class="mr-2 bi bi-envelope-fill fs-4 me-3 text-danger"></i>
                            <div>
                                <strong>{{ __('review.contact_email_label') }}</strong><br>
                                <a href="mailto:photoaigen2210@gmail.com">photoaigen2210@gmail.com</a>
                            </div>
                        </li>
                        <li class="mb-4 d-flex align-items-start">
                            <i class="mr-2 bi bi-telephone-fill fs-4 me-3 text-success"></i>
                            <div>
                                <strong>{{ __('review.contact_phone_label') }}</strong><br>
                                <a href="tel:0819288679">0768807473</a>
                            </div>
                        </li>
                    </ul>
                    {{-- nút chia sẽ --}}
                    <div class="bd-tag-share">
                        <div class="share mr-3">
                            <a href="#" class="mr-2 facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="mr-2 twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="mr-2 youtube"><i class="fa fa-youtube-play"></i></a>
                            <a href="#" class="mr-2 instagram"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
