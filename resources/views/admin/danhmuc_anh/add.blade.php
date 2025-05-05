@extends('admin.main')

@section('content')
    <form action="" method="POST">
        @method('POST')
        @csrf

        <div class="card-body bg-light">
            <div class="form-group">
                <label for="menu">Tên Danh Mục</label>
                <input type="text" name="name" class="form-control"  placeholder="Nhập tên danh mục">
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Tạo Danh Mục</button>
            <a type="submit" href="/admin/danhmucanh/list" class="btn btn-primary">Danh Sách</a>
        </div>
    </form>
@endsection


{{-- đoạn script này sẽ kích hoạt CKEditor cho trường textarea có id="content", 
giúp người dùng soạn thảo nội dung bài viết với các công cụ định dạng văn bản. --}}
@section('footer')
    <script>
        CKEDITOR.replace('content');
    </script>
@endsection
