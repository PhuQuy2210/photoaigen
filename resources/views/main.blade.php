<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body>
    @include('admin.alert')
    <!-- Header -->
    @include('header')

    @yield('content')

    @include('footer')
    @yield('footer')
</body>

</html>
