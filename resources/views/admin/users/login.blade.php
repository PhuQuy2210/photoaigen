<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.head')
    <style>
        body {
            background-image: url('/upload/hinhanh/1733795462.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>

<body class="hold-transition login-page col-md-12">
    <div class="no-radius font-si card card-primary  text-center">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-5">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card ">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        @include('admin.alert')

                        <form action="{{ route('xllogin') }}" method="post">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="input-group mb-3 d-flex align-items-center">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ old('email') }}">
                                <div class="input-group-append ms-3">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope line-height-2"></span>
                                    </div>
                                </div>
                            </div>

                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="input-group mb-3 d-flex align-items-center">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    value="123">
                                <div class="input-group-append ms-3">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock line-height-2"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="icheck-primary">
                                        <input type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">
                                            Lưu phiên đăng nhập trong 3 ngày
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>

                            <hr>
                            <span class="w-100 d-block text-center fw-bolder">OR</span>
                            <a href="{{ route('google.login') }}"
                                class="btn btn-primary btn-lg btn-block rounded-pill shadow-sm d-flex align-items-center justify-content-center">
                                <img src="{{ asset('upload/logo/gg.png') }}" alt="Google logo" width="20" height="20"
                                    class="me-2">
                                Đăng nhập với Google
                            </a>

                            <div class="row">
                                <div class="col-12">
                                    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account?
                                        <a href="register" class="link-danger">Register</a>
                                    </p>
                                </div>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.footer')
</body>

</html>
