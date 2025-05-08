<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin') }}" class="logo">
                <img src="{{ asset('template/admin/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                    class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        {{-- <span class="caret"></span> --}}
                    </a>
                    {{-- <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li class="nav_item">
                                <a href="../demo1/index.html">
                                    <span >Dashboard 1</span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#user">
                        <i class="far fa-id-card"></i>
                        <p>Tài Khoản</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="user">
                        <ul class="nav nav-collapse">
                            <li class="nav_item">
                                <a href="{{ route('users.create') }}">
                                    <i class="fas fa-user-plus ms-4"></i>
                                    <span>Thêm Tài Khoản</span>
                                </a>
                            </li>
                            <li class="nav_item">
                                <a href="{{ route('users.list') }}">
                                    <i class="fas fa-list-alt ms-4"></i>
                                    <span>Danh Sách Tài Khoản</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#image">
                        <i class="far fa-images"></i>
                        <p>Hình Ảnh</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="image">
                        <ul class="nav nav-collapse">
                            <li class="nav_item">
                                <a href="{{ route('hinhanh.list') }}">
                                    <i class="fas fa-list-alt ms-4"></i>
                                    <span>Danh Sách Ảnh</span>
                                </a>

                            </li>
                            <li class="nav_item">
                                <a href="{{ route('hinhanh.add') }}">
                                    <i class="far fa-file-image ms-4"></i>
                                    <span>Thêm Ảnh</span>
                                </a>
                            </li>
                            @if (Auth::check() && Auth::user()->role_id == 0)
                                <li class="nav_item">
                                    <a href="{{ route('menus.list') }}">
                                        <i class="fas fa-layer-group ms-4"></i>
                                        <span>Danh Mục Ảnh</span>
                                    </a>
                                </li>

                                <li class="nav_item">
                                    <a href="{{ route('danhmuccon.index') }}">
                                        <i class="fas fa-layer-group ms-4"></i>
                                        <span>Danh Mục Con</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#blog">
                        <i class="fas fa-pen-square"></i>
                        <p>Tin Tức</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="blog">
                        <ul class="nav nav-collapse">
                            <li class="nav_item">
                                <a href="{{ route('tintuc.add') }}">
                                    <i class="fas fa-pen-nib ms-4"></i>
                                    <span>Thêm Tin</span>
                                </a>
                            </li>
                            <li class="nav_item">
                                <a href="{{ route('tintuc.list') }}">
                                    <i class="fas fa-list-alt ms-4"></i>
                                    <span>Danh Sách Tin</span>
                                </a>
                            </li>
                            @if (Auth::check() && Auth::user()->role_id == 0)
                                <li class="nav_item">
                                    <a href="{{ route('danhmuctin.list') }}">
                                        <i class="fas fa-layer-group ms-4"></i>
                                        <span>Danh Mục Tin</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>

                @php
                    $countKiemDuyet = App\Models\BaoCao::where('kiemduyet', 0)->count();
                @endphp
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#report">
                        <i class="fa-solid fa-comment-dots"></i>
                        <p class="position-relative d-inline-block">
                            Báo Cáo
                            @if ($countKiemDuyet > 0)
                                <span
                                    class="badge badge-danger position-absolute top-0 start-100 translate-middle p-1 rounded-circle badge-space">
                                    {{ $countKiemDuyet }}
                                </span>
                            @endif
                        </p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse" id="report">
                        <ul class="nav nav-collapse">
                            <li class="nav_item">
                                <a href="{{ route('baocao.list') }}">
                                    <i class="fas fa-list-alt ms-4"></i>
                                    <span>List Report</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
