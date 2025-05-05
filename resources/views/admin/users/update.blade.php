@extends('admin.main')

@section('content')
    <form action="" method="POST">
        {{-- <input type="hidden" name="thumb_old" value="{{ $user->thumb }}" class="form-control"> --}}
        @include('admin.alert')
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">Tên tài khoản: </label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">email: </label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Quyền hạn: </label>
                        <select class="form-control" name="role_id">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kích Hoạt: </label>
                        <br>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $user->is_active == 1 ? ' checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Có</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $user->is_active == 0 ? ' checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">Không</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer bg-light">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
        @csrf
    </form>
@endsection
@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
