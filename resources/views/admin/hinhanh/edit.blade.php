@extends('admin.main')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf
        <input type="hidden" class="form-control" name="url_old" value="{{ $hinhanh->url }}">
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-12">
                    <!-- Mô tả hình ảnh -->
                    <div class="form-group">
                        <label for="description">Mô Tả Thể Loại:</label>
                        <div id="subcategory-buttons" class="mb-2">
                            @foreach ($catagory_img_childs as $danhmuccon)
                                <button type="button" class="btn btn-sm btn-outline-primary text-dark mb-1"
                                    onclick="addToDescription('{{ $danhmuccon->name }}')">
                                    {{ $danhmuccon->name }}
                                </button>
                            @endforeach
                        </div>
                        <textarea name="description" id="description" class="form-control" rows="2" placeholder="Nhập mô tả" required>{{ $hinhanh->description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Danh mục cha -->
                    <div class="form-group">
                        <label for="category_id">Danh Mục Cha: </label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach ($danhmucanh as $danhmuc)
                                <option value="{{ $danhmuc->id }}"
                                    {{ $hinhanh->category_id == $danhmuc->id ? 'selected' : '' }} required>
                                    {{ $danhmuc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Danh mục con -->
                    <div class="form-group">
                        <label for="category_child">Danh Mục Con: </label>
                        <select name="category_child" id="category_child" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach ($catagory_img_childs as $danhmuccon)
                                <option value="{{ $danhmuccon->id }}" data-parent-id="{{ $danhmuccon->parent_id }}"
                                    {{ $hinhanh->category_child == $danhmuccon->id ? 'selected' : '' }} required>
                                    {{ $danhmuccon->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="view">Lượt xem: </label>
                        <input for="view" type="number" name="view" value="{{ $hinhanh->view }}"
                            class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="like_count">Lượt like: </label>
                        <input for="like_count" type="number" name="like_count" value="{{ $hinhanh->like_count }}"
                            class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kích Hoạt: </label>
                        <br>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $hinhanh->active == 1 ? ' checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Có</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $hinhanh->active == 0 ? ' checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">Không</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hướng ảnh: </label>
                        <br>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_direction"
                                name="direction" {{ $hinhanh->direction == 0 ? ' checked=""' : '' }}>
                            <label for="no_direction" class="custom-control-label">Ngang</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="direction"
                                name="direction" {{ $hinhanh->direction == 1 ? ' checked=""' : '' }}>
                            <label for="direction" class="custom-control-label">Dọc</label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <!-- Hình ảnh -->
                    <div class="form-group">
                        <label for="menu">Hình ảnh: </label>
                        <input type="file" class="form-control" id="upload" name="url">
                        <div class="mt-2">
                            <img src="{{ asset($hinhanh->url) }}" alt="Hình ảnh hiện tại" class="img-thumbnail"
                                style="max-width: 200px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="{{ route('hinhanh.list') }}" class="btn btn-primary">Danh Sách</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
<h1 style="color: red"></h1>
@section('footer')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tự động lọc danh mục con khi trang được tải
            const categoryIdElement = document.getElementById('category_id');
            if (categoryIdElement.value) {
                categoryIdElement.dispatchEvent(new Event('change'));
            }
        });
    </script> --}}
@endsection
