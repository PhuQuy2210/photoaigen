@extends('main')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card">
            @include('admin.alert')
            @if (Auth::check())
                <!-- Profile Card -->
                <div class="container mt-5">
                    <div class="card profile-card shadow rounded">
                        <div class="row no-gutters">
                            <!-- Left section: Avatar and name -->
                            <div
                                class="col-md-4 bg-primary text-white d-flex flex-column align-items-center justify-content-center p-4 rounded-start">
                                <img src="{{ $userDetail->avatar_url ?? '/upload/hinhdaidien/default.png' }}" alt="Avatar"
                                    class="rounded-circle mb-3 border border-white" width="120" height="120">
                                <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                                {{-- <small>Mã số: {{ Auth::user()->MaSo }}</small> --}}
                            </div>

                            <!-- Right section: Info -->
                            <div class="col-md-8 p-4">
                                <h5 class="mb-3 border-bottom pb-2">Thông tin chi tiết</h5>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-2">
                                        <strong>Email:</strong> <br>
                                        <span class="text-muted">{{ Auth::user()->email }}</span>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <strong>Bạn đã like:</strong> <br>
                                        <span class="text-muted">{{ $likedCount }} pictures</span><br>

                                        @if ($likedCount > 1)
                                            <span class="text-success">Cảm ơn bạn đã like ảnh từ trang web của mình
                                                😍</span>
                                        @else
                                            <span class="text-warning">Hãy like vài ảnh để ủng hộ tụi mình nhé 🥺</span>
                                        @endif
                                    </div>

                                    {{-- <div class="col-sm-6 mb-2">
                                    <strong>Ngày sinh:</strong> <br>
                                    <span class="text-muted">{{ $admin->NgaySinh }}</span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <strong>Địa chỉ:</strong> <br>
                                    <span class="text-muted">{{ $admin->DiaChi }}</span>
                                </div> --}}
                                    <div class="col-sm-6 mb-2">
                                        <strong>Ngày tạo:</strong> <br>
                                        <span class="text-muted">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p>Bạn chưa đăng nhập.</p>
            @endif
            <style>
                .profile-card {
                    overflow: hidden;
                    border-radius: 15px;
                }

                .profile-card .bg-primary {
                    background: linear-gradient(135deg, #007bff, #0056b3);
                }

                .profile-card img {
                    object-fit: cover;
                }
            </style>

            <div class="card-footer">
                {{-- @if (!Auth::user()->socialAccounts->where('provider', 'google')->count())
                    <a href="/account-user/edit-info" class="btn btn-primary">Cập nhật thông tin</a>
                    <a href="/account-user/edit-user" class="btn btn-secondary">Đổi mật khẩu</a>
                @endif --}}
                <a href="/images-user-like/{{ Auth::user()->id }}" class="btn btn-primary">Bộ sưu tập</a>
            </div>
        </div>
    </div>
@endsection
