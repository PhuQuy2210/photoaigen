@extends('admin.main')

@section('content')
    @include('admin.alert')
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col" style="width: 50px">ID</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">Quyền</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Nâng quyền</th>
                <th scope="col">Khóa</th>
                <th style="width: 140px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    {{-- Quyền: 2 = User, 1 = staff, 0 = Admin --}}
                    <td>
                        @if ($user->role_id == 2)
                            Người dùng
                        @elseif ($user->role_id == 1)
                            Nhân viên
                        @else
                            Quản trị viên
                        @endif
                    </td>

                    {{-- Trạng thái tài khoản --}}
                    <td>
                        @if ($user->is_active == 0)
                            Đã khóa
                        @else
                            Hoạt động
                        @endif
                    </td>

                    <td>
                        {{-- Chỉ hiển thị nút phân quyền với tài khoản Người dùng --}}
                        @if ($user->role_id != 0)
                            <a class="btn btn-sm btn-primary" onclick="return checkRole({{ Auth::user()->role_id }})"
                                href="{{ route('users.upgrade', $user->id) }}">
                                Nâng quyền
                            </a>
                        @endif
                        @if ($user->role_id == 1)
                            <a class="btn btn-sm btn-secondary" onclick="return checkRole({{ Auth::user()->role_id }})"
                                href="{{ route('users.downgrade', $user->id) }}">
                                Hạ quyền
                            </a>
                        @endif
                    </td>
                    <td>
                        {{-- Nút khóa / mở khóa tài khoản --}}
                        @if ($user->is_active == 1 && $user->role_id != 0)
                            <a href="{{ route('users.lock', $user->id) }}" class="btn btn-sm btn-warning"
                                onclick="return checkRole({{ Auth::user()->role_id }})">
                                <i class="fas fa-lock"></i>
                            </a>
                        @elseif ($user->role_id != 0)
                            <a href="{{ route('users.unlock', $user->id) }}" class="btn btn-sm btn-success"
                                onclick="return checkRole({{ Auth::user()->role_id }})">
                                <i class="fas fa-lock-open"></i>
                            </a>
                        @endif
                    </td>

                    <td style="text-align: center">
                        {{-- Nút cập nhật tài khoản --}}
                        <a class="btn btn-sm btn-warning me-1" onclick="return checkRole({{ Auth::user()->role_id }})"
                            href="{{ route('users.show', $user->id) }}">
                            <i class="fas fa-edit"></i>
                         </a>
                        <span> </span>
                        {{-- Nút xóa tài khoản --}}
                        <a href="#"
                            onclick="return checkPermission({{ Auth::user()->role_id }}, {{ $user->id }}, '{{ route('users.destroy') }}')"
                            class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $users->links() !!}
    </div>

    </script>
@endsection
