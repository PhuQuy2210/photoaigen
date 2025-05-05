<!-- Header Begin -->
<header class="header-section">
    <div class="container-fluid">
        <div class="row align-items-center background-header color-header">
            <div class="col-3 header-padding">
                <div class="logo">
                    <a href="/">
                        <img src="/template/img/logo.png" alt="LOGO">
                    </a>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-start header-padding">
                <div class="show-from-600">
                    <nav class="nav-menu mobile-menu">
                        <ul class="d-flex flex-lg-row justify-content-center">
                            <li><a href="/"> {{ __('messages.wallpaper') }}</a></li>
                            <li><a href="/blog"> {{ __('messages.news') }}</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Menu mobile hiển thị dưới 600px -->
                <div class="mr-4 button-togger-margin hide-from-600">
                    <div id="mobile-menu-wrap"></div>
                </div>
            </div>

            <div class="header-padding col-4 d-flex justify-content-end align-items-center resize-padding">
                @if (Auth::check())
                    {{-- avata --}}
                    <div class="profile-user">
                        <li class="list-unstyled" id="user-profile">
                            <a class="dropdown-toggle profile-pic d-flex align-items-center" data-bs-toggle="dropdown"
                                href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ $userDetail->avatar_url ?? '/upload/hinhdaidien/default.png' }}"
                                         alt="Avatar"
                                         class="avatar-img rounded-circle"
                                         onerror="this.onerror=null;this.src='/upload/hinhdaidien/default.png';" />
                                </div>                                
                                <span class="profile-username ms-2">
                                    <span class="op-7">Hi,</span>
                                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn"
                                style="z-index: 200; background-color: #2c2f34;">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <img src="{{ $userDetail->avatar_url ?? '/upload/hinhdaidien/default.png' }}"
                                                    alt="Avatar" class="avatar-img rounded" />
                                            </div>
                                            <div class="u-text">
                                                <h4>{{ Auth::user()->name }}</h4>
                                                <p>{{ Auth::user()->email }}</p>
                                                <a href="/account-user/info-user"
                                                    class="btn btn-xs btn-secondary btn-sm p-2">{{ __('messages.account') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="font-profi" style="width: 100%">
                                        @if (Auth::user()->role_id == 0)
                                            <a class="dropdown-item p-2"
                                                href="/admin/">{{ __('messages.admin_panel') }}</a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item p-2 {{ request()->is('images-user-like/*') ? 'active' : '' }}"
                                            href="/images-user-like/{{ Auth::user()->id }}">{{ __('messages.gallery') }}</a>
                                        {{-- <a class="dropdown-item p-2 {{ request()->is('account-user/*') ? 'active' : '' }}"
                                            href="/account-user/info-user">{{ __('messages.edit_info') }}</a> --}}
                                        <a class="dropdown-item p-2"
                                            href="/users/logout">{{ __('messages.logout') }}</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </div>
                @else
                    {{-- Xử lý đăng kí đăng nhập --}}
                    <div class="d-flex justify-content-end" style="min-width: 160px">
                        <!-- Nút Đăng Ký -->
                        {{-- <a href="admin/users/register"
                            class="btn btn-hover custom-register me-3 custom-min-width color-header">{{ __('messages.sign_up') }}</a>

                        <!-- Nút Đăng Nhập -->
                        <a href="/admin/users/login"
                            class="btn btn-hover custom-login custom-min-width color-header">{{ __('messages.login') }}</a> --}}
                        <a href="{{ route('google.login') }}"
                            class="btn btn-hover custom-register me-3 custom-min-width color-header">{{ __('messages.sign_up') }}</a>

                        <!-- Nút Đăng Nhập -->
                        <a href="{{ route('google.login') }}"
                            class="btn btn-hover custom-login custom-min-width color-header">{{ __('messages.login') }}</a>
                    </div>
                @endif
                
            </div>
        </div>

        {{-- header phụ --}}
        <div class="row bg-nav-header">
            <nav class="navbar navbar-light w-100 flex-nowrap">
                <!-- Nút Toggler (chỉ hiển thị ở 650px trở xuống) -->

                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-button"><i class="bi bi-list-ul"></i></span>
                </button>

                <div class="category-list collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto navbar-dropdown">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/"
                                data-sort="created_at" data-filter="">
                                {{ __('messages.latest') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('images-popular') ? 'active' : '' }}"
                                href="/images-popular" data-sort="like_count" data-filter="">
                                {{ __('messages.popular') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('images-viewCount') ? 'active' : '' }}"
                                href="/images-viewCount" data-sort="like_count" data-filter="">
                                {{ __('messages.view_count') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('images-random') ? 'active' : '' }}"
                                href="/images-random" data-sort="random" data-filter="">
                                {{ __('messages.random') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('images-vertical') || request()->is('images-horizontal') ? 'active' : '' }}"
                                href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-sort="direction">
                                {{ __('messages.orientation') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item {{ request()->is('images-random') ? 'active' : '' }}"
                                    href="/images-random" data-sort="random" data-filter="">
                                    {{ __('messages.any') }}
                                </a>
                                <a class="dropdown-item {{ request()->is('images-vertical') ? 'active' : '' }}"
                                    href="/images-vertical" data-sort="direction" data-filter="0">
                                    {{ __('messages.vertical') }}
                                </a>
                                <a class="dropdown-item {{ request()->is('images-horizontal') ? 'active' : '' }}"
                                    href="/images-horizontal" data-sort="direction" data-filter="1">
                                    {{ __('messages.horizontal') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                
                {{-- language --}}
                <div class="box_language" title="{{ __('messages.languages') }}">
                    {{-- Cho màn hình lớn --}}
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ app()->getLocale() == 'vi' ? asset('upload/logo/vi.png') : asset('upload/logo/en.png') }}"
                                alt="flag" width="20" class="me-1">
                            <span class="d-none d-md-inline">
                                {{ app()->getLocale() == 'vi' ? 'Tiếng Việt' : 'English' }}
                            </span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <a class="dropdown-item" href="{{ route('switch.language', ['lang' => 'en']) }}">
                                <img src="{{ asset('upload/logo/en.png') }}" width="20" class="me-1"> English
                            </a>
                            <a class="dropdown-item" href="{{ route('switch.language', ['lang' => 'vi']) }}">
                                <img src="{{ asset('upload/logo/vi.png') }}" width="20" class="me-1"> Tiếng
                                Việt
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Dark Mode --}}
                <div class="box_darkmode" title="{{ __('messages.bg_color') }}">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="darkmode" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-brightness-high-fill"></i>
                            <span class="d-none d-md-inline">{{ __('messages.interface') }}</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="darkmode">
                            <a class="dropdown-item" href="#" onclick="setTheme('light')"
                                title="{{ __('messages.light') }}">
                                <i class="bi bi-sun"></i> {{ __('messages.light') }}
                            </a>
                            <a class="dropdown-item" href="#" onclick="setTheme('dark')"
                                title="{{ __('messages.dark') }}">
                                <i class="bi bi-moon"></i> {{ __('messages.dark') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="position-relative search  ">
                    <form class="form-inline my-2 my-lg-0 d-flex flex-nowrap" id="search-form"
                        action="{{ route('home.search') }}" method="GET">
                        <input class="form-control mr-sm-2 search-input" type="search"
                            placeholder="{{ __('messages.category_id_or_description') }}" aria-label="Search"
                            id="search-input" name="search" autocomplete="off">
                        <button class="btn btn-outline-success my-2 my-sm-0 d-none d-md-block"
                            type="submit">Search</button>
                    </form>

                    <!-- Lịch sử tìm kiếm dạng combobox -->
                    <div id="search-history-dropdown" class="dropdown-menu w-100" style="display: none;"></div>
                </div>
            </nav>
        </div>
    </div>
</header>
