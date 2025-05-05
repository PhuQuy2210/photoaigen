<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>admin</title>
<meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
<link rel="icon" href="/template/admin/img/kaiadmin/favicon.ico" type="image/x-icon" />

<!-- Fonts and icons -->
<script src="/template/admin/js/plugin/webfont/webfont.min.js"></script>
{{-- <script>
    WebFont.load({
        google: {
            families: ["Public Sans:300,400,500,600,700"]
        },
        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["/template/admin/css/fonts.min.css"],
        },
        active: function() {
            sessionStorage.fonts = true;
        },
    });
</script> --}}
 <!-- MDBootstrap CSS -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet" />

 <!-- Font Awesome -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

<!-- CSS Files -->
<link rel="stylesheet" href="/template/admin/css/bootstrap.min.css" />
<link rel="stylesheet" href="/template/admin/css/plugins.min.css" />
<link rel="stylesheet" href="/template/admin/css/kaiadmin.min.css" />
<link rel="stylesheet" href="/template/css/style.css" />
<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="/template/admin/css/demo.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
