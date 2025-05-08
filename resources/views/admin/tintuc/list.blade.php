@extends('admin.main')

@section('content')
    <table style="text-align: center" class="table table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tille</th>
                <th>Tác giả</th>
                <th>Lượt xem</th>
                <th>Trạng thái</th>
                <th>Danh Mục</th>
                <th>Ảnh</th>
                <th style="width: 140px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lists as $bg)
                <tr>
                    <td>{{ $bg->id }}</td>
                    <td style="max-width: 220px;">{{ $bg->title }}</td>
                    <td>{{ $bg->author->name ?? 'Ẩn danh' }}</td>
                    <td>{{ $bg->view }}</td>
                    <td>
                        {{-- Nút kích hoạt / vô hiệu hóa tin --}}
                        @if ($bg->active == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"
                                onclick="toggleActive({{ $bg->id }}, '{{ route('tintuc.disable') }}')">
                                <i class="fas fa-eye"></i> Hoạt động
                            </a>
                        @else
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                                onclick="toggleActive({{ $bg->id }}, '{{ route('tintuc.enable') }}')">
                                <i class="fas fa-eye-slash"></i> Bị khóa
                            </a>
                        @endif
                    </td>
                    <td>{{ $bg->category->name }}</td>
                    <td>
                        <img class="size-image img-thumbnail mx-auto d-block view-image" src="{{ $bg->first_image_url }}"
                            onerror="this.onerror=null;this.src='{{ asset('upload/hinhdaidien/default.png') }}';"
                            alt="Ảnh minh họa">
                    </td>
                    <td style="text-align: center">
                        {{-- Nút cập nhật tin --}}
                        <a class="btn btn-sm btn-warning me-1" href="{{ route('tintuc.edit', ['tintuc' => $bg->id]) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- Nút xóa tin --}}
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="delete_tintuc({{ $bg->id }}, '{{ route('tintuc.destroy') }}')">
                            <i class="fas fa-trash"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <div class="bg-light ">
                    <a href="{{ route('tintuc.add') }}" class="btn btn-sm btn-primary add-catagory mt-3 mb-2">
                        Thêm tin
                    </a>
                </div>
            </tr>
        </tfoot>
    </table>
    @include('admin.page')
@endsection
