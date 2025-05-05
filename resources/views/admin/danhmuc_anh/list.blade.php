@extends('admin.main')

@section('content')
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Trạng thái</th>
                <th style="width: 140px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($danhmucanh as $danhmuc)
                <tr>
                    <td>{{ $danhmuc->id }}</td>
                    <td>{{ $danhmuc->name }}</td>
                    <td>
                        @if ($danhmuc->active == 0)
                            Đã khóa
                        @else
                            Hoạt động
                        @endif
                    </td>
                    <td style="text-align: center">
                        <!-- Các thao tác như chỉnh sửa hoặc xóa tài khoản -->
                        <a href="/admin/danhmucanh/edit/{{ $danhmuc->id }}" class="btn btn-sm btn-warning me-1"><i
                                class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="deleteDanhmuc({{ $danhmuc->id }}, '/admin/danhmucanh/destroy')"><i
                                class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <div class="bg-light ">
                    <a href="/admin/danhmucanh/add" class="btn btn-sm btn-primary add-catagory mt-3 mb-2">
                        {{-- <i class="fas fa-plus"></i>  --}}
                        Thêm danh mục
                    </a>
                </div>
            </tr>
        </tfoot>
    </table>
@endsection
