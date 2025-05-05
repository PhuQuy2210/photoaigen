@extends('admin.main')

@section('content')
    @include('admin.alert')
        
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên người dùng: </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                            placeholder="Nhập tên người dùng">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email: </label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                            placeholder="Nhập email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mật Khẩu: </label>
                        <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                            placeholder="Nhập password">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <button type="submit" class="btn btn-primary">Thêm người dùng</button>
        </div>
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
