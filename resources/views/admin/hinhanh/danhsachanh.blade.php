@section('head')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
<table style="text-align: center" class="table table-hover table-striped">
    <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Danh mục</th>
            <th>Mô tả</th>
            <th>Trạng thái</th>
            <th>Hướng</th>
            <th>Ảnh</th>
            <th style="width: 140px; text-align: center;">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lists as $img)
            <tr>
                <td>{{ $img->id }}</td>
                <td>{{ $img->category->name ?? 'Không có danh mục' }}</td>
                <td class="text-start">{!! $img->description !!}</td>
                <td>
                    {{-- Nút kích hoạt / vô hiệu hóa hình ảnh --}}
                    @if ($img->active == 1)
                        <a href="javascript:void(0);" class="btn btn-sm btn-success"
                            onclick="toggleActive({{ $img->id }}, '/admin/hinhanh/disable')">
                            <i class="fas fa-eye"></i> Hoạt động
                        </a>
                    @else
                        <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                            onclick="toggleActive({{ $img->id }}, '/admin/hinhanh/enable')">
                            <i class="fas fa-eye-slash"></i> Bị khóa
                        </a>
                    @endif
                </td>
                <td>
                    @if ($img->direction == 1)
                        <span>Dọc</span>
                    @else
                        <span>Ngang</span>
                    @endif
                </td>
                <td>
                    <img class="size-image img-thumbnail mx-auto d-block view-image" src="{{ asset($img->full_thumb) }}"
                        alt="{{ $img->name }}" data-src="{{ asset($img->full_url) }}">
                </td>
                <td style="text-align: center">
                    {{-- Nút cập nhật hình ảnh --}}
                    <a class="btn btn-sm btn-warning me-1" href="/admin/hinhanh/edit/{{ $img->id }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    {{-- Nút xóa hình ảnh --}}
                    <a href="#" class="btn btn-sm btn-danger"
                        onclick="delete_hinhanh({{ $img->id }}, '/admin/hinhanh/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal hiển thị hình ảnh -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Xem Ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid" src="" alt="Hình ảnh"
                    style="max-height: 70vh; filter: contrast(110%) brightness(105%);
                    -webkit-filter: saturate(120%) contrast(110%);">
            </div>
        </div>
    </div>
</div>

@include('admin.hinhanh.page') <!-- Chứa phân trang -->

@section('footer')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".view-image", function() {
                let imgSrc = $(this).attr("data-src");
                $("#modalImage").attr("src", imgSrc);
                $("#imageModal").modal("show");
            });

            // Bắt sự kiện đóng modal bằng nút "X"
            $(document).on("click", ".btn-close", function() {
                $("#imageModal").modal("hide");
            });

            // Khi modal đóng, focus vào body để tránh lỗi trợ năng
            $("#imageModal").on("hidden.bs.modal", function() {
                $("body").focus();
            });
        });
    </script>
    <script src="{{ asset('/template/js/ajax/danhsach_anh.js') }}"></script>
@endsection
