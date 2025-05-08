@extends('admin.main')

@section('content')
    <form action="" method="POST">
        <div class="card-body bg-light">
            <div class="form-group ">
                <label for="menu">Tên Danh Mục Con: </label>
                <input type="text" name="name" value="{{ $danhmuc->name }}" class="form-control"
                    placeholder="Nhập tên danh mục">
            </div>

            <!-- Danh mục cha -->
            <div class="form-group">
                <label for="danhmuc_id">Danh Mục Cha: </label>
                <select name="danhmuc_id" id="danhmuc_id" class="form-control">
                    {{-- <option value="">Chọn danh mục</option> --}}
                    @foreach ($danhmuc_cha as $dm)
                        @if ($dm->active == 1)
                            <option value="{{ $dm->id }}" {{ $dm->danhmuc_id == $danhmuc->id ? 'selected' : '' }}>
                                {{ $dm->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
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
        <div class="card-footer bg-light d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Cập Nhật Danh Mục</button>
            <a type="submit" href="{{ route('danhmuccon.index') }}" class="btn btn-primary">Danh Sách</a>
        </div>
        @csrf
    </form>
@endsection
