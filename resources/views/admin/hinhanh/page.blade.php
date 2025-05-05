<div class="d-flex justify-content-center align-items-center mt-3 mb-2">
    <span class="text-muted pagination-page fw-bold">
        Page: {{ $lists->currentPage() }} / {{ $lists->lastPage() }}
    </span>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Nút Previous -->
            <li class="page-item {{ $lists->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $lists->previousPageUrl() ?? '#' }}">Previous</a>
            </li>

            @php
                $currentPage = $lists->currentPage();
                $lastPage = $lists->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            <!-- Trang đầu tiên -->
            @if ($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $lists->url(1) }}">1</a>
                </li>
                @if ($start > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            <!-- Các trang xung quanh -->
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $lists->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Trang cuối cùng -->
            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $lists->url($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            <!-- Nút Next -->
            <li class="page-item {{ $lists->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $lists->nextPageUrl() ?? '#' }}">Next</a>
            </li>
        </ul>
    </nav>
</div>
