@extends('main')

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
                    <label for="name">Tên người dùng: </label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
@endsection
