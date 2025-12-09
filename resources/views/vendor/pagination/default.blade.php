<style>
.pagination{
    border: 1px solid #ccc;
    width: fit-content;
}
.pagination li span{
    border-left: 1px solid #ccc;
}
.pagination li:not(:last-child) a{
    border-left: 1px solid #ccc;
}
.pagination li.active span{
    background-color: #247e14;
    color: #fff;
}
.pagination span{
    width: 40px;
    text-align: center;
}
.pagination a{
    padding: 10px;
    width: 40px;
    display: inline-block;
    text-align: center  ;
}
.pagination span{
    padding: 10px;
    display: inline-block;
}
</style>

@if ($paginator->hasPages())
    <nav>
        <ul class="pagination d-flex">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a class="p-2" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
