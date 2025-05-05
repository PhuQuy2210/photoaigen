@extends('admin.main')

@section('content')
    <form action="" method="POST">
        @method('POST')
        @csrf
        <div class="card-body bg-light">
            <div class="form-group">
                <label for="menu">Tên Danh Mục Con:</label>
                <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục" required>
            </div>

            <!-- Danh mục -->
            <div class="form-group">
                <label for="danhmuc_id">Danh Mục Cha: </label>
                <select name="danhmuc_id" id="danhmuc_id" class="form-control">
                    <option value="">Chọn danh mục</option>
                    @foreach ($danhmucanh as $danhmuc)
                        <option value="{{ $danhmuc->id }}">{{ $danhmuc->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Tạo Danh Mục</button>
            <a href="/admin/danhmuccon_anh/list" class="btn btn-primary">Danh Sách</a>
        </div>
    </form>
@endsection
