@if ($paginator->hasPages())
    <div class="paging">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="disabled"><span>«</span></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagging_normal">«</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="pagging_active"><span>{{ $page }}</span></a>
                    @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                        <a class="pagging_normal" href="{{ $url }}">{{ $page }}</a>
                    @elseif ($page == $paginator->lastPage() - 1)
                        <a class="disabled"><span>...</span></a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagging_normal">»</a>
        @else
            <a class="disabled"><span>»</span></a>
        @endif
    </div>
@endif
