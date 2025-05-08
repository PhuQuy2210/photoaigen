<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.head')
</head>

<body class="hold-transition login-page col-md-12">
    <div class="no-radius font-si card card-primary text-center">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-5">
            <div class="login-box">
                <div class="login-logo text-center">
                    <a href="#"><b>
                            <h2>Đăng Ký</h2>
                        </b></a>
                </div>
                <!-- /.login-logo -->
                <div class="card ">
                    <div class="card-body login-card-body">
                        <form action="{{ route('users.register.store') }}" method="post">
                            <div class="input-group mb-3 d-flex align-items-center">
                                <input type="text" name="name" class="form-control" placeholder="fullname"
                                    required>
                                <div class="input-group-append ms-3">
                                    <div class="input-group-text">
                                        <span class="fas fa-user line-height-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3 d-flex align-items-center">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                                <div class="input-group-append ms-3">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope line-height-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3 d-flex align-items-center">
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Password" required>
                                <div class="input-group-append ms-3">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock line-height-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3 d-flex align-items-center">
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="form-control" placeholder="Confirm Password" required>
                                <div class="input-group-append ms-3">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock line-height-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>
                            <hr>
                            <span class="w-100 d-block text-center fw-bolder">OR</span>
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary"
                                style="background-color: #dd4b39;" type="submit"><i class="fab fa-google me-2"></i>
                                Đăng nhập với google</button>

                            <div class="row">
                                <div class="col-12">
                                    <p class="small fw-bold mt-2 pt-1 mb-0">Quay lại đăng nhập? <a
                                            href="{{ route('login') }}" class="link-danger">Login</a></p>
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
za

</html>
