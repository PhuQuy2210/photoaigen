@extends('admin.main')

@section('content')
    <form action="" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf
        <input type="hidden" class="form-control" name="url_old" value="{{ $tintuc->url }}">

        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="view">Title: </label>
                        <input for="view" type="text" name="title" value="{{ $tintuc->title }}"
                            class="form-control" value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="author_id">Tác giả: </label>
                        <select name="author_id" id="author_id" class="form-control">
                            <option value="{{ Auth::user()->id }}"
                                {{ old('author_id', Auth::user()->id) == Auth::user()->id ? 'selected' : '' }}>
                                {{ Auth::user()->name }}</option>
                            @foreach ($users as $user)
                                @if (Auth::user()->id != $user->id)
                                    <option value="{{ $user->id }}"
                                        {{ old('author_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('author_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Mô tả: </label>
                        <textarea name="description" class="form-control" rows="2" >{{ $tintuc->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="content">Nội dung:</label>
                        <textarea name="content" id="editor" class="form-control" rows="5">{{ $tintuc->content }}</textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="view">Lượt xem: </label>
                        <input for="view" type="number" name="view" value="{{ $tintuc->view }}"
                            class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kích Hoạt: </label>
                        <br>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                                {{ $tintuc->active == 1 ? ' checked=""' : '' }}>
                            <label for="active" class="custom-control-label">Có</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                                {{ $tintuc->active == 0 ? ' checked=""' : '' }}>
                            <label for="no_active" class="custom-control-label">Không</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Danh mục -->
                    <div class="form-group">
                        <label for="category_id">Danh mục: </label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($danhmuctin as $danhmuc)
                                <option value="{{ $danhmuc->id }}"
                                    {{ $tintuc->category_id == $danhmuc->id ? 'selected' : '' }}>
                                    {{ $danhmuc->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Hình ảnh -->
                    <div class="form-group">
                        <label for="menu">Hình ảnh: </label>
                        <input type="file" class="form-control" name="url">
                        @error('url')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="/admin/tintuc/list" class="btn btn-primary">Danh Sách</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
@section('footer')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
    <script src="/template/admin/js/ckeditor.js"></script>
@endsection
