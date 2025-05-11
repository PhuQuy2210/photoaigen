<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.head')
    <meta name="route-danhsach-anh" content="{{ route('hinhanh.list') }}">
    <style>
        i {
            color: white !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Sidebar --}}
        @include('admin.sidebar')

        <div class="main-panel">
            {{-- header --}}
            @include('admin.header')

            {{-- Content --}}
            <div class="content-wrapper pb-40">
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        @include('admin.alert')

                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-primary mt-1">
                                    <div class="card-header">
                                        <h3 class="card-title">{{ $title }}</h3>
                                    </div>

                                    {{-- Nội dung bên admin.home được chèn vào đây   --}}
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Footer --}}
            @include('admin.footer')
            @yield('footer')
        </div>
    </div>
</body>

</html>
