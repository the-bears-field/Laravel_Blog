@if($paginator->hasPages())
    {{-- Previous Page Link --}}
    <div class="paginator__nav flex-direction-row">
        @if(!$paginator->onFirstPage())
            <a href="{{ $paginator->url(1) }}" class="pagenator__link" title="first page"><i class="fas fa-angle-double-left"></i></a>
            <a href="{{ $paginator->previousPageUrl() }}" class="pagenator__link" title="previous page"><i class="fas fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagenator__link" aria-disabled="true"><i class="fas fa-ellipsis-h"></i></span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                       <span class="pagenator__link_current"><b>{{ $page }}</b></span>
                    @else
                        <a href="{{ $url }}" class="pagenator__link" title="page {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagenator__link" title="next page"><i class="fas fa-chevron-right"></i></a>
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagenator__link" title="last page"><i class="fas fa-angle-double-right"></i></a>
        @endif
    </div>
@endif
