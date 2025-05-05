@extends('admin.main')

@section('content')
    <form action="" method="POST">
        <div class="card-body bg-light">
            <div class="form-group ">
                <label for="menu">Tên Danh Mục</label>
                <input type="text" name="name" value="{{ $danhmuc->name }}" class="form-control"
                    placeholder="Nhập tên danh mục">
            </div>

            <div class="form-group">
                <label>Kích Hoạt: </label>
                <br>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                        {{ $danhmuc->active == 1 ? ' checked=""' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                        {{ $danhmuc->active == 0 ? ' checked=""' : '' }}>
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <button type="submit" class="btn btn-primary">Cập Nhật Danh Mục</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
