@php
    $selectedSort = $selected ?? request('sort', 'latest');
    $selectClass = trim('sort-select ' . ($class ?? ''));
@endphp

<form method="GET" action="{{ $action }}" class="{{ $formClass ?? '' }}">
    <div class="{{ $selectClass }}">
        <select name="sort" class="sort-select__native" aria-hidden="true" tabindex="-1">
            <option value="latest" @selected($selectedSort === 'latest')>Latest</option>
            <option value="popular" @selected($selectedSort === 'popular')>Popular</option>
        </select>

        <button type="button"
                class="sort-select__trigger"
                aria-haspopup="listbox"
                aria-expanded="false">
            <span class="sort-select__text">{{ $selectedSort === 'popular' ? 'Popular' : 'Latest' }}</span>
            <i class="fa-solid fa-chevron-down sort-select__icon" aria-hidden="true"></i>
        </button>

        <ul class="sort-select__menu" role="listbox">
            <li class="sort-select__option @if($selectedSort === 'latest') sort-select__option--selected @endif"
                role="option"
                data-value="latest"
                aria-selected="{{ $selectedSort === 'latest' ? 'true' : 'false' }}">
                Latest
            </li>
            <li class="sort-select__option @if($selectedSort === 'popular') sort-select__option--selected @endif"
                role="option"
                data-value="popular"
                aria-selected="{{ $selectedSort === 'popular' ? 'true' : 'false' }}">
                Popular
            </li>
        </ul>
    </div>
</form>
