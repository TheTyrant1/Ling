@php
    $uid = 'search_' . uniqid();
    $placeholder = $placeholder ?? 'Search posts, users...';
@endphp

<div class="search search--header {{ $class ?? '' }}"
     id="{{ $uid }}_root"
     data-search
     data-search-uid="{{ $uid }}"
     data-search-endpoint="{{ $endpoint ?? route('admin.search.index') }}">
    <button type="button" class="search__trigger search__trigger--desktop" id="{{ $uid }}_trigger" aria-label="Open search">
        <i class="fa-solid fa-magnifying-glass search__trigger-icon"></i>
        <span class="search__trigger-text">{{ $placeholder }}</span>
        <span class="search__shortcut">
            <kbd>Shift</kbd>
            <kbd>Shift</kbd>
        </span>
    </button>

    <button type="button" class="search__trigger search__trigger--mobile" id="{{ $uid }}_trigger_mobile" aria-label="Open search">
        <i class="fa-solid fa-magnifying-glass search__trigger-icon"></i>
    </button>
</div>

<div class="search__overlay" id="{{ $uid }}_overlay" aria-hidden="true">
    <div class="search__backdrop" id="{{ $uid }}_backdrop"></div>
    <div class="search__modal" role="dialog" aria-modal="true" aria-label="Search">
        <div class="search__modal-header">
            <i class="fa-solid fa-magnifying-glass search__header-icon"></i>
            <input
                type="text"
                class="search__input"
                id="{{ $uid }}_input"
                placeholder="{{ $placeholder }}"
                autocomplete="off"
                spellcheck="false"
            >
            <button type="button" class="search__close" id="{{ $uid }}_close" aria-label="Close search">
                <kbd class="search__close-kbd">Esc</kbd>
                <i class="fa-solid fa-xmark search__close-icon"></i>
            </button>
        </div>

        <div class="search__body" id="{{ $uid }}_body">
            <div class="search__state search__state--idle" id="{{ $uid }}_idle">
                <div class="search__state-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <p>Enter a keyword to find records...</p>
            </div>

            <div class="search__state search__state--loading" id="{{ $uid }}_loading" hidden>
                <div class="search__spinner"></div>
            </div>

            <div class="search__results" id="{{ $uid }}_results" hidden></div>

            <div class="search__state search__state--empty" id="{{ $uid }}_empty" hidden>
                <div class="search__state-icon">
                    <i class="fa-regular fa-face-frown"></i>
                </div>
                <p>No results for "<span id="{{ $uid }}_query"></span>"</p>
            </div>
        </div>

        <div class="search__footer">
            <div class="search__hints">
                <span class="search__hint-item search__hint-item--navigate"><kbd><i class="fa-solid fa-arrows-up-down"></i></kbd> Navigate</span>
                <span class="search__hint-item search__hint-item--select"><kbd><i class="fa-solid fa-arrow-turn-down"></i></kbd> Select</span>
                <span class="search__hint-item search__hint-item--close">
                    <kbd class="search__kbd--desktop">Esc</kbd>
                    <kbd class="search__kbd--mobile"><i class="fa-solid fa-arrow-left"></i></kbd>
                    Close
                </span>
            </div>
        </div>
    </div>
</div>
