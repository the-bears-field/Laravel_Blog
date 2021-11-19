@if($paginator->lastPage() > 1)
    <div class="paginator__nav flex-direction-row">
        @if($paginator->currentPage() !== 1)
            <a href="/" class="pagenator__link" title="previous page"><i class="fas fa-chevron-left"></i></a>
        @endif
        @for($i = 1; $i <= $paginator->lastPage(); $i++)
            @if($paginator->currentPage() === $i)
                <span class="pagenator__link_current"><b>{{ $i }}</b></span>
            @else
                <a href="{{ $i === 1 ? '/' : '/?page='. $i }}" class="pagenator__link" title="page {{ $i }}">{{ $i }}</a>
            @endif
        @endfor
        @if($paginator->currentPage() !== $paginator->lastPage())
            <a href="/?page={{ $paginator->lastPage() }}" class="pagenator__link" title="next page"><i class="fas fa-chevron-right"></i></a>
        @endif
    </div>
@endif
