<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- SEO -->
<meta name="description" content="{{ __('messages.meta_description') }}">
<meta name="keywords" content="PhotoAIgen, AI wallpapers, free backgrounds, high resolution photos, photography, ảnh nền AI, hình nền miễn phí, ảnh đẹp, desktop, mobile">
<meta name="author" content="PhotoAIgen Team">


<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title }}</title>
<link rel="icon" type="image/png" href="{{ asset('upload/logo/web.png') }}">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Quantico:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

<!-- Bootstrap JS (defer tải sau HTML) -->
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Critical CSS: tải sớm -->
<link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/css/style.css') }}">

<!-- Trì hoãn CSS phụ -->
<link rel="preload" href="{{ asset('template/css/font-awesome.min.css') }}" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('template/css/font-awesome.min.css') }}">
</noscript>

<link rel="preload" href="{{ asset('template/css/elegant-icons.css') }}" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('template/css/elegant-icons.css') }}">
</noscript>

<link rel="preload" as="style" href="{{ asset('template/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/css/owl.carousel.min.css') }}" media="all">

<link rel="preload" as="style" href="{{ asset('template/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('template/css/magnific-popup.css') }}" media="all">

<link rel="preload" href="{{ asset('template/css/slicknav.min.css') }}" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('template/css/slicknav.min.css') }}">
</noscript>

<link rel="preload" href="{{ asset('template/css/list-images.css') }}" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('template/css/list-images.css') }}">
</noscript>

<link rel="preload" href="{{ asset('template/css/reponsive.css') }}" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('template/css/reponsive.css') }}">
</noscript>

<link rel="preload" as="style" href="{{ asset('template/admin/css/kaiadmin.min.css') }}">
<link rel="stylesheet" href="{{ asset('template/admin/css/kaiadmin.min.css') }}" media="all">
