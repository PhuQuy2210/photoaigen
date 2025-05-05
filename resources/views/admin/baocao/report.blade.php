@extends('admin.main')

@section('content')
    <div class="breadcrumb-option spad p-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box-report p-4 shadow rounded bg-white pt-2 pe-2">
                        <div class="text-end">
                            <a href="/admin/baocao/list" class="btn btn-primary">Quay lại</a>
                        </div>

                        <h3 class="mb-4 text-center">Thông báo vi phạm bản quyền</h3>
                        <p class="text-muted">
                            Sử dụng mẫu đơn này để xác định nội dung trên PhotoAIGen mà bạn muốn khiếu nại dựa trên vi phạm
                            bản quyền bị cáo buộc.
                        </p>
                        <hr>

                        {{-- <!-- Box chứa ID ảnh và Hình ảnh -->
                        <div class="image-box p-4 shadow rounded bg-light mb-4 d-flex align-items-center">
                            <h4 class="me-5">ID ảnh: {{ $image->id }}</h4>
                            <img src="{{ asset($image->url) }}" alt="Image" class="img-fluid" style="max-width: 300px; max-height; 400px;">
                        </div> --}}
                        <!-- Box chứa ID ảnh và Hình ảnh -->
                        <div class="image-box p-4 shadow rounded bg-light mb-4 d-flex align-items-center">
                            <!-- Cột chứa ID ảnh -->
                            <div class="col-md-6">
                                <h4 class="me-5">ID ảnh: {{ $image->id }}</h4>
                                <img src="{{ asset($image->url) }}" alt="Image" class="img-fluid"
                                    style="max-width: 300px; max-height: 400px;">
                            </div>

                            <!-- Cột chứa các nút -->
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <!-- Nút kích hoạt / vô hiệu hóa hình ảnh -->
                                @if ($baocao->kiemduyet == 1)
                                    <a href="javascript:void(0);" class="btn btn-sm btn-success me-2"
                                        onclick="toggleActive({{ $baocao->id }}, '/admin/baocao/disable')">
                                        <i class="fas fa-eye"></i> Đã kiểm duyệt
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-sm btn-warning me-2"
                                        onclick="toggleActive({{ $baocao->id }}, '/admin/baocao/enable')">
                                        <i class="fas fa-eye-slash"></i> Kiểm duyệt
                                    </a>
                                @endif

                                <!-- Nút xóa hình ảnh vi phạm -->
                                <a href="#" class="btn btn-sm btn-danger" title="Xác nhận xóa ảnh"
                                    onclick="delete_report_img({{ $baocao->hinhanh_id }}, '/admin/baocao/destroy_img')">
                                    <i class="fa-solid fa-image"></i> Xóa ảnh
                                </a>
                            </div>
                        </div>

                        <!-- id của ảnh -->
                        {{-- <input type="hidden" name="hinhanh_id" value="{{ $image->id }}"> --}}

                        <h2>Thông tin liên hệ:</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label"><strong>Họ và tên: </strong></label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $user->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label"><strong>Email liên hệ:</strong></label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ $baocao->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sdt" class="form-label"><strong>Số điện thoại:</strong></label>
                                    <input type="number" name="sdt" class="form-control" id="sdt"
                                        value="{{ $baocao->sdt }}" placeholder="Nhập số điện thoại" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quocgia" class="form-label"><strong>Quốc gia:</strong></label>
                                    <input type="text" name="quocgia" class="form-control" id="quocgia"
                                        value="{{ $baocao->quocgia }}" placeholder="Nhập quốc gia" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h2>Nội dung vi phạm:</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="originalContent" class="form-label"><strong>Liên kết đến hình ảnh
                                            gốc</strong></label>
                                    <input type="url" name="url" class="form-control" id="originalContent"
                                        value="{{ $baocao->url }}" placeholder="Dán liên kết đến nội dung gốc" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label"><strong>Mô tả chi tiết về vi
                                            phạm</strong></label>
                                    <textarea name="description" class="form-control" id="description" rows="4"
                                        placeholder="Mô tả chi tiết về nội dung vi phạm" required>{{ $baocao->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h2>Lời cam kết:</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="mb-3 form-check d-flex align-items-baseline">
                                        <input class="custom-control-input me-2" type="checkbox" name="commitment"
                                            id="check_form" checked required>
                                        <label for="check_form" class="custom-control-label d-block text-wrap">
                                            Tôi cam kết rằng thông tin cung cấp là đúng sự thật và tôi là chủ sở hữu
                                            bản
                                            quyền hoặc được ủy quyền để đại diện cho chủ sở hữu bản quyền.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
