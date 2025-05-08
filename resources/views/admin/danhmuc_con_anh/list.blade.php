@extends('admin.main')

@section('content')
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Name</th>
                <th>Name Parent</th>
                <th>Trạng thái</th>
                <th style="text-align: center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($danhmuccon_anh as $danhmuc)
                <tr>
                    <td>{{ $danhmuc->id }}</td>
                    <td>{{ $danhmuc->name }}</td>
                    <td>{{ $danhmuc->parent ? $danhmuc->parent->name : 'Không có danh mục cha' }}</td>
                    <td>
                        @if ($danhmuc->active == 0)
                            Đã khóa
                        @else
                            Hoạt động
                        @endif
                    </td>
                    <td style="text-align: center">
                        <a href="{{ route('danhmuccon.show', ['danhmuc' => $danhmuc->id]) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="deleteDanhmuc({{ $danhmuc->id }}, '{{ route('danhmuccon.destroy') }}')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <div class="bg-light ">
                    <a href="{{ route('danhmuccon.create') }}" class="btn btn-sm btn-primary add-catagory mt-3 mb-2">
                        {{-- <i class="fas fa-plus"></i> --}}
                        Thêm danh mục
                    </a>                    
                </div>
            </tr>
        </tfoot>
    </table>
@endsection