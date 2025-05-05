@extends('admin.main')

@section('content')
    <form action="{{ route('tintuc.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="view">Title: </label>
                        <input for="view" type="text" name="title" placeholder="Nhập title" class="form-control"
                            value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <!-- Danh mục -->
                    <div class="form-group">
                        <label for="category_id">Danh mục: </label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach ($danhmuctin as $danhmuc)
                                <option value="{{ $danhmuc->id }}"
                                    {{ old('category_id') == $danhmuc->id ? 'selected' : '' }}>{{ $danhmuc->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Mô tả: </label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Nhập mô tả nội dung">{{ old('description') }}</textarea>
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
                        <textarea name="content" id="editor" class="form-control" rows="5" placeholder="Nhập nội dung">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Hình ảnh -->
                    <div class="form-group">
                        <label for="menu">Hình ảnh: </label>
                        <!-- Kéo-thả hoặc chọn nhiều ảnh -->
                        <div id="drop-area" class="border border-primary rounded p-3 text-center bg-white">
                            <p class="text-muted mb-2">Kéo thả ảnh vào đây hoặc nhấn để chọn ảnh</p>
                            <input type="file" id="fileElem" name="url[]" multiple accept="image/*"
                                style="display:none;">
                            <button type="button" class="btn btn-sm btn-outline-primary mb-2"
                                onclick="document.getElementById('fileElem').click()">Chọn ảnh</button>
                            <div id="preview" class="mt-3 d-flex flex-wrap gap-2 justify-content-between"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between">
            <a href="/admin/tintuc/list" class="btn btn-primary">Danh Sách</a>
            <button type="submit" class="btn btn-primary">Tạo Tin</button>
        </div>
    </form>
@endsection
@section('footer')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
    <script src="/template/admin/js/ckeditor.js"></script>

    <script>
        // Đảm bảo DOM đã sẵn sàng
        document.addEventListener('DOMContentLoaded', () => {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('fileElem');
            const preview = document.getElementById('preview');

            // Chặn hành vi mặc định ở cấp độ document cho dragover và drop
            ['dragover', 'drop'].forEach(eventName => {
                document.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            // Ngăn chặn hành vi mặc định cho drop-area
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            // Thêm hiệu ứng khi kéo vào vùng drop
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.add('border-success');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.remove('border-success');
                }, false);
            });

            // Xử lý khi thả file
            dropArea.addEventListener('drop', e => {
                console.log('Drop event triggered', e.dataTransfer.files); // Debug
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleFiles(files);
                }
            }, false);

            // Xử lý khi chọn file qua input
            fileInput.addEventListener('change', () => {
                console.log('File input changed', fileInput.files); // Debug
                if (fileInput.files.length > 0) {
                    handleFiles(fileInput.files);
                }
            });

            function handleFiles(files) {
                // Xử lý từng file
                for (let file of files) {
                    if (file.type.startsWith('image/')) {
                        previewFile(file);
                    }
                }

                // Cập nhật file vào input
                updateFileInput(files);
            }

            function previewFile(file) {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = () => {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('position-relative', 'd-inline-block');

                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.style.width = '200px';
                    // img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.classList.add('rounded', 'm-1');
                    img.dataset.fileName = file.name; // Lưu tên file để xóa

                    // Nút xóa
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = 'X';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0',
                        'end-0');
                    removeBtn.style.transform = 'translate(-8%, 13%);';
                    removeBtn.onclick = () => {
                        imgContainer.remove();
                        updateFileInput();
                    };

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    preview.appendChild(imgContainer);
                };
            }

            function updateFileInput(newFiles = null) {
                const dataTransfer = new DataTransfer();
                const currentFiles = Array.from(fileInput.files);
                const previewImages = preview.querySelectorAll('img');

                // Nếu có file mới, thêm vào danh sách
                if (newFiles) {
                    Array.from(newFiles).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            dataTransfer.items.add(file);
                        }
                    });
                } else {
                    // Chỉ giữ lại các file tương ứng với ảnh còn trong preview
                    previewImages.forEach(img => {
                        const file = currentFiles.find(f => f.name === img.dataset.fileName);
                        if (file) {
                            dataTransfer.items.add(file);
                        }
                    });
                }

                fileInput.files = dataTransfer.files;
            }
        });
    </script>
    <style>
        #drop-area {
            min-height: 150px;
            border: 2px dashed #007bff;
            transition: all 0.3s ease;
        }

        #drop-area.border-success {
            border-color: #28a745;
        }

        #preview img:hover {
            opacity: 0.8;
        }
    </style>
@endsection
