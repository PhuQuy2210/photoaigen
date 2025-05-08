@extends('admin.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center bg-light">
        <div class="d-flex ms-3">
            <a href="{{ route('hinhanh.add') }}" class="btn btn-sm btn-primary add-catagory">
                Thêm ảnh
            </a>            
        </div>
        <div class="d-flex align-items-center">
            <div class="form-group d-flex align-items-center">
                <label class="me-2 mb-0" for="category_id">Danh mục:</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">-- Chọn tất cả --</option>
                    @foreach ($danhMucs as $danhmuc)
                        <option value="{{ $danhmuc->id }}" {{ $category_id == $danhmuc->id ? 'selected' : '' }}>
                            {{ $danhmuc->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-end search-sv me-3">
                <form id="search-form" class="d-flex">
                    <input class="form-control me-2" type="search" name="search" placeholder="Nhập ID hoặc Mô Tả">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </div>

    {{-- danh sách ảnh --}}
    <div id="student-list">
        @include('admin.hinhanh.danhsachanh')
    </div>
    
@endsection
