@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-around" style="width: 100%;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled text-center">
                    <button class="btn btn-dark btn--icon" type="button"><i class="fas fa-angle-left"></i></button>
                </li>
            @else
                <li class="page-item text-center">
                    <a class="btn btn-light btn--icon" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-angle-left"></i></a>
                </li>
            @endif

            <li style="width: 10%;"></li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item text-center">
                    <a class="btn btn-light btn--icon" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-angle-right"></i></a>
                </li>
            @else
                <li class="page-item disabled text-center">
                    <button class="btn btn-dark btn--icon" type="button"><i class="fas fa-angle-right"></i></button>
                </li>
            @endif
        </ul>
    </nav>
@endif
