@if ($paginator->hasPages())
    <nav class="pager">
        <ul class="pager__list">
            @if ($paginator->onFirstPage())
                <li class="pager__item pager__item--disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="pager__link" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                </li>
            @else
                <li class="pager__item">
                    <a class="pager__link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pager__item pager__item--disabled" aria-disabled="true"><span class="pager__link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pager__item pager__item--active" aria-current="page"><span class="pager__link">{{ $page }}</span></li>
                        @else
                            <li class="pager__item"><a class="pager__link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="pager__item">
                    <a class="pager__link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            @else
                <li class="pager__item pager__item--disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="pager__link" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
