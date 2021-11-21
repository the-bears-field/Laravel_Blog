{{-- 変数、定数の定義 --}}
{{-- ページネーションのリンク数を定義 --}}
@php
    define('PAGINATE_LINK_NUM', 10)
@endphp

{{-- 定数よりもページ数が多い時 --}}
@if ($paginator->lastPage() > PAGINATE_LINK_NUM)

    {{-- 現在ページが表示するリンクの中心位置よりも左の時 --}}
    @if ($paginator->currentPage() <= floor(PAGINATE_LINK_NUM / 2))
        @php
            $startPage = 1;
            $endPage   = PAGINATE_LINK_NUM;
        @endphp

    {{-- 現在ページが表示するリンクの中心位置よりも右の時 --}}
    @elseif ($paginator->currentPage() > $paginator->lastPage() - floor(PAGINATE_LINK_NUM / 2))
        @php
            $startPage = $paginator->lastPage() - (PAGINATE_LINK_NUM - 1);
            $endPage   = $paginator->lastPage();
        @endphp

    {{-- 現在ページが表示するリンクの中心位置の時 --}}
    @else
        @php
            $startPage = intval(round($paginator->currentPage() - floor(PAGINATE_LINK_NUM % 2 == 0 ? PAGINATE_LINK_NUM - 1 : PAGINATE_LINK_NUM) / 2));
            $endPage   = intval(round($paginator->currentPage() + floor(PAGINATE_LINK_NUM / 2)));
        @endphp
    @endif
{{-- 定数よりもページ数が少ない時 --}}
@else
    @php
        $startPage = 1;
        $endPage   = $paginator->lastPage();
    @endphp
@endif

{{-- 以下ビューの出力 --}}
@if($paginator->hasPages())
    <div class="paginator__nav flex-direction-row">
        {{-- Previous Page Link --}}
        @if(!$paginator->onFirstPage())
            <a href="{{ $paginator->url(1) }}" class="pagenator__link" title="first page"><i class="fas fa-angle-double-left"></i></a>
            <a href="{{ $paginator->previousPageUrl() }}" class="pagenator__link" title="previous page"><i class="fas fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @for($i = $startPage; $i <= $endPage; $i++)
            @if($paginator->currentPage() === $i)
                <span class="pagenator__link_current"><b>{{ $i }}</b></span>
            @else
                <a href="{{ $paginator->url($i) }}" class="pagenator__link" title="page {{ $i }}">{{ $i }}</a>
            @endif
        @endfor

        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagenator__link" title="next page"><i class="fas fa-chevron-right"></i></a>
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagenator__link" title="last page"><i class="fas fa-angle-double-right"></i></a>
        @endif
    </div>
@endif
