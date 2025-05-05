@extends('admin.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $title }}</h3>
        </div>
        <div>
            @include('admin.alert')
        </div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <label for="current_password">Mật khẩu cũ:</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu mới:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Nhập lại mật khẩu mới:</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật mật khẩu:</button>
            </form>
        </div>
    </div>
@endsection
