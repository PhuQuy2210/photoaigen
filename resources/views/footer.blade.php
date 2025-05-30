<!-- Footer Section Begin -->
<footer class="footer-section bottom-0">
    <div class="container d-flex flex-wrap justify-content-center">
        {{-- <div class="row"> --}}
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="fs-about">
                <div class="fa-logo">
                    <a href="#">
                        <img src="{{ asset('template/img/f-logo.png') }}" alt="">
                    </a>
                </div>
                <p>{{ __('messages.explore') }}</p>
                <div class="fa-social">
                    <a href="https://www.facebook.com/profile.php?id=100095548688065"><i class="fa fa-facebook"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100095548688065"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100095548688065"><i
                            class="fa fa-youtube-play"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100095548688065"><i
                            class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="fs-widget cta-text">
                <h5>{{ __('messages.quick_Links') }}</h5>
                <ul>
                    <li>
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}"
                            data-sort="created_at" data-filter="">
                            {{ __('messages.latest') }}
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->is('images-popular') ? 'active' : '' }}"
                            href="{{ route('images.popular') }}" data-sort="like_count" data-filter="">
                            {{ __('messages.popular') }}
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->is('images-viewCount') ? 'active' : '' }}"
                            href="{{ route('images.viewCount') }}" data-sort="like_count" data-filter="">
                            {{ __('messages.view_count') }}
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a class="nav-link {{ request()->is('images-random') ? 'active' : '' }}"
                            href="{{ route('images.random') }}" data-sort="random" data-filter="">
                            {{ __('messages.random') }}
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.orientation') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('images.random') }}" data-sort="random"
                                data-filter="">
                                {{ __('messages.any') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('images.vertical') }}" data-sort="direction"
                                data-filter="0">
                                {{ __('messages.vertical') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('images.horizontal') }}" data-sort="direction"
                                data-filter="1">
                                {{ __('messages.horizontal') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="fs-widget cta-text">
                <h5>{{ __('messages.introduce') }}</h5>
                <div class="gioihieu">
                    <li><a href="{{ route('home.about_us') }}">{{ __('messages.about_Us') }}</a></li>
                    <li><a href="{{ route('home.contact_us') }}">{{ __('messages.contact_us') }}</a></li>
                    <li><a href="{{ route('home.terms_of_Service') }}">{{ __('messages.terms_of_Service') }}</a></li>
                    <li><a href="{{ route('home.privacy_Policy') }}">{{ __('messages.privacy_Policy') }}</a></li>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="copyright-text">
                <p>
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    <span>Made with <i class="bi bi-heart-fill text-danger"></i> by AI</span>
                </p>
            </div>
        </div>
        {{-- </div> --}}
    </div>
</footer>
<!-- Footer Section End -->


<!-- Nút Back to Top -->
{{-- <button onclick="backToTop()" id="backToTopBtn" class="position-fixed bottom-0 end-0 mb-4 me-4 backToTop"
    style="display: none; z-index: 100;" title="Back to top">
    <i class="bi bi-arrow-up-square"></i>
</button> --}}
<div class="backtotop">
    <a id="scrollTop">
        <i class="bi bi-chevron-up first-icon"></i>
        <i class="bi bi-chevron-up second-icon"></i>
    </a>
</div>

<!-- vòng tròn load khi load trang -->
{{-- <div class="spinner">
    <div class="blob blob-0"></div>
</div> --}}

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- jQuery (phải trước Bootstrap) -->
{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --}}
<!-- Js Plugins -->
{{-- <script src="{{ asset('template/js/jquery-3.3.1.min.js') }}"></script> --}}
<script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('template/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('template/js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('template/js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('template/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('template/js/main.js') }}"></script>
<script src="{{ asset('template/admin/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('template/js/design.js') }}"></script>
