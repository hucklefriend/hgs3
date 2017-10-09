@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center" style="width: 100%;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled text-center" style="width: 30%;"><span class="page-link">前</span></li>
            @else
                <li class="page-item text-center" style="width: 30%;"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">前</a></li>
            @endif

            <li style="width: 10%;"></li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item text-center" style="width: 30%;"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">次</a></li>
            @else
                <li class="page-item disabled text-center" style="width: 30%;"><span class="page-link">次</span></li>
            @endif
        </ul>
    </nav>
@endif
