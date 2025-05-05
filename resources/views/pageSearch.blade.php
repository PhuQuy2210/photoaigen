<div class="d-flex justify-content-center align-items-center mt-5 pb-4">
    <span class="text-muted pagination-page fw-bold">{{ __('messages.page') }}: {{ $lists->currentPage() }} / {{ $lists->lastPage() }}</span>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @php
                $searchQuery = request('search') ? '&search=' . urlencode(request('search')) : ''; // Giữ search nếu có
            @endphp

            <!-- Nút Previous -->
            @if ($lists->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $lists->previousPageUrl() . $searchQuery }}">Previous</a>
                </li>
            @endif

            <!-- Hiển thị các trang -->
            @php
                $currentPage = $lists->currentPage();
                $lastPage = $lists->lastPage();
                $start = max($currentPage - 2, 1);
                $end = min($currentPage + 2, $lastPage);
            @endphp

            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $lists->url(1) . $searchQuery }}">1</a>
                </li>
                @if ($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $currentPage)
                    <li class="page-item active">
                        <span class="page-link">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $lists->url($i) . $searchQuery }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $lists->url($lastPage) . $searchQuery }}">{{ $lastPage }}</a>
                </li>
            @endif

            <!-- Nút Next -->
            @if ($lists->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $lists->nextPageUrl() . $searchQuery }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
