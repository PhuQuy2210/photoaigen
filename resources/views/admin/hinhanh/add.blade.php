@extends('admin.main')

@section('content')
    <form action="{{ route('hinhanh.store') }}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf

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
                        <textarea name="description" id="description" class="form-control" rows="2" placeholder="Nhập mô tả" required></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <!-- Danh mục cha -->
                    <div class="form-group">
                        <label for="category_id">Danh Mục Cha: </label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Chọn danh mục</option>
                            @foreach ($danhmucanh as $danhmuc)
                                <option value="{{ $danhmuc->id }}">{{ $danhmuc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Danh mục con -->
                    <div class="form-group">
                        <label for="category_child">Danh Mục Con: </label>
                        <select name="category_child" id="category_child" class="form-control" required>
                            <option value="">Chọn danh mục con</option>
                            @foreach ($catagory_img_childs as $danhmuccon)
                                <option value="{{ $danhmuccon->id }}" data-parent-id="{{ $danhmuccon->parent_id }}">
                                    {{ $danhmuccon->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hướng ảnh: </label>
                        <br>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="1" type="radio" id="chieu_doc"
                                name="direction" checked>
                            <label for="chieu_doc" class="custom-control-label">Dọc</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" value="0" type="radio" id="chieu_ngang"
                                name="direction">
                            <label for="chieu_ngang" class="custom-control-label">Ngang</label>
                        </div>
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
            <a href="/admin/hinhanh/list" class="btn btn-primary">Danh Sách</a>
            <button type="submit" class="btn btn-primary">Thêm Ảnh</button>
        </div>
    </form>
@endsection
@section('footer')
    <script src="{{ asset('template/admin/js/catagory.js') }}"></script>
    {{-- bình thường cho kéo --}}
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

    {{-- bình thường không cho kéo --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('fileElem');
            const preview = document.getElementById('preview');
    
            if (!fileInput || !preview) {
                console.error('Không tìm thấy phần tử:', { fileInput, preview });
                return;
            }
    
            // Xử lý khi chọn file qua input
            fileInput.addEventListener('change', () => {
                console.log('File input changed', fileInput.files);
                if (fileInput.files.length > 0) {
                    handleFiles(fileInput.files);
                }
            });
    
            function handleFiles(files) {
                for (let file of files) {
                    if (file.type.startsWith('image/')) {
                        previewFile(file);
                    }
                }
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
                    img.style.objectFit = 'cover';
                    img.classList.add('rounded', 'm-1');
                    img.dataset.fileName = file.name;
    
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = 'X';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0');
                    removeBtn.style.transform = 'translate(-8%, 13%)';
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
    
                if (newFiles) {
                    Array.from(newFiles).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            dataTransfer.items.add(file);
                        }
                    });
                } else {
                    previewImages.forEach(img => {
                        const file = currentFiles.find(f => f.name === img.dataset.fileName);
                        if (file) {
                            dataTransfer.items.add(file);
                        }
                    });
                }
    
                fileInput.files = dataTransfer.files;
                console.log('Updated file input:', fileInput.files);
            }
        });
    </script> --}}

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
