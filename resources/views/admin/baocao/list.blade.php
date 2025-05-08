@extends('admin.main')

@section('content')
    <table style="text-align: center" class="table table-hover table-striped">
        <thead>
            <tr>
                <th style="width: 50px">STT</th>
                <th style="width: 50px">ID ảnh</th>
                <th style="width: 200px">Mô tả</th>
                <th>Kiểm duyệt</th>
                <th>email</th>
                <th>Ảnh</th>
                <th style="width: 140px; text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lists as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->hinhanh_id }}</td>
                    <td class="des-link">
                        <a href="{{ route('admin.baocao', $report->id) }}">
                            {{ $report->description }}
                        </a>
                    </td>
                    <td>
                        {{-- Nút kích hoạt / vô hiệu hóa hình ảnh --}}
                        @if ($report->kiemduyet == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-success"
                                onclick="toggleActive({{ $report->id }}, '{{ route('baocao.disable') }}')">
                                <i class="fas fa-eye"></i> Đã kiểm duyệt
                            </a>
                        @else
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                                onclick="toggleActive({{ $report->id }}, '{{ route('baocao.enable') }}')">
                                <i class="fas fa-eye-slash"></i> Kiểm duyệt
                            </a>
                        @endif

                    </td>
                    <td>{{ Auth::user()->email }}</td>
                    <td>
                        <img class="size-image img-thumbnail mx-auto d-block view-image"
                            src="{{ asset($report->hinhanh->full_url) }}" alt="{{ $report->name }}"
                            data-src="{{ asset($report->hinhanh->full_url) }}">
                    </td>
                    {{-- Thao tác --}}
                    <td style="text-align: center">
                        {{-- Nút xóa report --}}
                        <a href="#" class="btn btn-sm btn-danger" title="Xóa report"
                            onclick="delete_report({{ $report->id }}, '{{ route('baocao.destroy') }}')">
                            <i class="fas fa-trash"></i>
                        </a>
                        {{-- Nút xóa hình ảnh vi phạm --}}
                        <a href="#" class="btn btn-sm btn-danger" title="Xát nhận xóa ảnh"
                            onclick="delete_report_img({{ $report->hinhanh_id }}, '{{ route('baocao.destroy_img') }}')">
                            <i class="fa-solid fa-image"></i>
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
    @include('admin.page')
@endsection
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
@endsection
