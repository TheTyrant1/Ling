@php
    $uid = 'us_' . uniqid();
@endphp

{{-- Trigger Button (desktop: full bar, mobile: icon only) --}}
<div class="unified-search-trigger {{ $class ?? '' }}"
     style="{{ $style ?? '' }}"
     id="{{ $uid }}_trigger"
     data-endpoint="{{ $endpoint ?? '/search' }}"
     data-uid="{{ $uid }}">
    {{-- Desktop full trigger --}}
    <button type="button" class="us-trigger-btn us-trigger-desktop" id="{{ $uid }}_btn" aria-label="Open search">
        <i class="fa-solid fa-magnifying-glass us-trigger-icon"></i>
        <span class="us-trigger-text">{{ $placeholder ?? 'Search...' }}</span>
        <span class="us-trigger-kbd">
            <kbd>Shift</kbd>
            <kbd>Shift</kbd>
        </span>
    </button>
    {{-- Mobile icon trigger --}}
    <button type="button" class="us-trigger-mobile" id="{{ $uid }}_btn_mobile" aria-label="Open search">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</div>

{{-- Overlay Modal --}}
<div class="us-overlay" id="{{ $uid }}_overlay" aria-hidden="true">
    <div class="us-backdrop" id="{{ $uid }}_backdrop"></div>
    <div class="us-modal" role="dialog" aria-modal="true" aria-label="Search">
        {{-- Header --}}
        <div class="us-modal-header">
            <i class="fa-solid fa-magnifying-glass us-header-icon"></i>
            <input
                type="text"
                class="us-input"
                id="{{ $uid }}_input"
                placeholder="{{ $placeholder ?? 'Type to search...' }}"
                autocomplete="off"
                spellcheck="false"
            >
            <button type="button" class="us-close-btn" id="{{ $uid }}_close" aria-label="Close search">
                <kbd>Esc</kbd>
            </button>
        </div>

        {{-- Body --}}
        <div class="us-modal-body" id="{{ $uid }}_body">
            {{-- Idle --}}
            <div class="us-state us-idle" id="{{ $uid }}_idle">
                <div class="us-idle-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <p>Enter a keyword to find records…</p>
            </div>

            {{-- Loading --}}
            <div class="us-state us-loading" id="{{ $uid }}_loading" style="display:none;">
                <div class="us-spinner"></div>
            </div>

            {{-- Results --}}
            <div class="us-results" id="{{ $uid }}_results" style="display:none;"></div>

            {{-- No Results --}}
            <div class="us-state us-no-results" id="{{ $uid }}_noresults" style="display:none;">
                <div class="us-nores-icon">
                    <i class="fa-regular fa-face-frown"></i>
                </div>
                <p>No results for "<span id="{{ $uid }}_query_ph"></span>"</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="us-modal-footer">
            <div class="us-hints">
                <span><kbd>↑↓</kbd> Navigate</span>
                <span><kbd>Enter</kbd> Select</span>
                <span><kbd>Esc</kbd> Close</span>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     Unified Search Styles (included once via CSS dedup in blade)
     ============================================================ --}}
@once
<style>
/* ─── Trigger ─── */
.unified-search-trigger {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.us-trigger-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    max-width: 520px;
    padding: 9px 18px;
    background: rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 50px;
    color: #9ca3af;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}
.us-trigger-btn:hover {
    background: rgba(0,0,0,0.07);
    border-color: rgba(0,0,0,0.15);
    color: #111;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}

.us-trigger-icon { font-size: 13px; color: #9ca3af; }

.us-trigger-text { white-space: nowrap; }

.us-trigger-kbd {
    margin-left: auto;
    display: flex;
    gap: 4px;
}
.us-trigger-kbd kbd {
    background: rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 5px;
    padding: 2px 6px;
    font-size: 10px;
    color: #9ca3af;
    font-weight: 600;
    font-family: inherit;
}

/* ─── Overlay ─── */
.us-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 12vh;
    opacity: 0;
    visibility: hidden;
    transition: opacity .22s ease, visibility .22s ease;
}
.us-overlay.active {
    opacity: 1;
    visibility: visible;
}

.us-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(10,10,20,0.45);
    backdrop-filter: blur(10px) saturate(140%);
    -webkit-backdrop-filter: blur(10px) saturate(140%);
}

/* ─── Modal ─── */
.us-modal {
    position: relative;
    width: 95%;
    max-width: 660px;
    background: rgba(255,255,255,0.94);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255,255,255,0.5);
    border-radius: 18px;
    box-shadow:
        0 25px 70px rgba(0,0,0,0.14),
        0 8px 24px rgba(0,0,0,0.08),
        0 0 0 1px rgba(0,0,0,0.04);
    overflow: hidden;
    transform: scale(.95) translateY(-16px);
    transition: transform .28s cubic-bezier(.4,0,.2,1);
}
.us-overlay.active .us-modal {
    transform: scale(1) translateY(0);
}

/* ─── Header ─── */
.us-modal-header {
    display: flex;
    align-items: center;
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}
.us-header-icon {
    font-size: 17px;
    color: #9ca3af;
    margin-right: 14px;
    flex-shrink: 0;
}
.us-input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-size: 1.15rem;
    font-weight: 400;
    color: #111827;
    caret-color: #6366f1;
    font-family: inherit;
}
.us-input::placeholder { color: #b0b5c3; }

.us-close-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px 8px;
    transition: all .15s ease;
}
.us-close-btn:hover { transform: scale(1.12); }
.us-close-btn kbd {
    background: rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 5px;
    padding: 3px 8px;
    font-size: 11px;
    color: #9ca3af;
    font-weight: 600;
    font-family: inherit;
}

/* ─── Body ─── */
.us-modal-body {
    max-height: 460px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.12) transparent;
}
.us-modal-body::-webkit-scrollbar { width: 5px; }
.us-modal-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 5px; }

/* ─── States ─── */
.us-state {
    padding: 3.5rem 2rem;
    text-align: center;
    color: #9ca3af;
    font-size: 0.95rem;
}
.us-idle-icon, .us-nores-icon {
    font-size: 2rem;
    margin-bottom: 0.75rem;
    opacity: 0.35;
}

.us-spinner {
    width: 30px;
    height: 30px;
    border: 3px solid rgba(0,0,0,0.06);
    border-top-color: #6366f1;
    border-radius: 50%;
    animation: us-spin .75s linear infinite;
    margin: 0 auto;
}
@keyframes us-spin { to { transform: rotate(360deg); } }

/* ─── Results ─── */
.us-results-group {
    padding: 0.75rem 0;
    animation: us-fadeIn .22s ease forwards;
}
.us-results-group:not(:last-child) {
    border-bottom: 1px solid rgba(0,0,0,0.04);
}

@keyframes us-fadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}

.us-group-title {
    padding: 0.4rem 1.5rem 0.5rem;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.09em;
    color: #9ca3af;
    font-weight: 700;
}

.us-group-list {
    display: flex;
    flex-direction: column;
    padding: 0 0.65rem;
}

/* ─── Tag tags (for blog categories) ─── */
.us-tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 0.15rem 1.5rem 0.5rem;
}
.us-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    background: rgba(0,0,0,0.035);
    border: 1px solid rgba(0,0,0,0.06);
    border-radius: 50px;
    font-size: 12.5px;
    font-weight: 500;
    text-decoration: none !important;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s ease;
}
.us-tag:hover, .us-tag.active {
    background: rgba(99,102,241,0.08);
    color: #6366f1;
    border-color: rgba(99,102,241,0.2);
}

/* ─── Result item ─── */
.us-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0.7rem 0.85rem;
    text-decoration: none !important;
    color: #111827;
    border-radius: 12px;
    cursor: pointer;
    transition: all .12s ease;
}
.us-item:hover, .us-item.active {
    background: rgba(99,102,241,0.07);
}

/* Visual (thumbnail / icon) */
.us-item-visual {
    width: 56px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(0,0,0,0.04);
    overflow: hidden;
    flex-shrink: 0;
}
.us-item-visual img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.us-item-visual i {
    font-size: 1rem;
    color: #6b7280;
}

/* User avatar variant */
.us-item.type-user .us-item-visual {
    width: 44px;
    height: 44px;
    border-radius: 50%;
}

/* Info */
.us-item-info {
    flex: 1;
    min-width: 0;
}
.us-item-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
}
.us-item-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.us-item-badge {
    padding: 2px 8px;
    font-size: 10px;
    font-weight: 700;
    color: #9ca3af;
    background: rgba(0,0,0,0.045);
    border-radius: 5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    flex-shrink: 0;
}
.us-item-subtitle {
    font-size: 0.8125rem;
    color: #9ca3af;
    margin-top: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ─── Footer ─── */
.us-modal-footer {
    padding: 0.65rem 1.5rem;
    background: rgba(0,0,0,0.015);
    border-top: 1px solid rgba(0,0,0,0.06);
}
.us-hints {
    display: flex;
    gap: 18px;
    font-size: 0.72rem;
    color: #9ca3af;
}
.us-hints kbd {
    background: rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 4px;
    padding: 1px 5px;
    color: #6b7280;
    font-weight: 600;
    font-family: inherit;
}

/* ─── Dark theme ─── */
html[data-bs-theme="dark"] .us-trigger-btn {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.1);
    color: #9ca3af;
}
html[data-bs-theme="dark"] .us-trigger-btn:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.18);
    color: #f3f4f6;
}
html[data-bs-theme="dark"] .us-trigger-kbd kbd {
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,255,255,0.12);
    color: #9ca3af;
}

html[data-bs-theme="dark"] .us-modal {
    background: rgba(24,26,33,0.96);
    border-color: rgba(255,255,255,0.08);
    box-shadow:
        0 25px 70px rgba(0,0,0,0.5),
        0 0 0 1px rgba(255,255,255,0.04);
}
html[data-bs-theme="dark"] .us-modal-header,
html[data-bs-theme="dark"] .us-modal-footer {
    border-color: rgba(255,255,255,0.06);
}
html[data-bs-theme="dark"] .us-modal-footer {
    background: rgba(255,255,255,0.015);
}
html[data-bs-theme="dark"] .us-input { color: #f3f4f6; }
html[data-bs-theme="dark"] .us-input::placeholder { color: #6b7280; }
html[data-bs-theme="dark"] .us-close-btn kbd {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.1);
    color: #9ca3af;
}
html[data-bs-theme="dark"] .us-item-title { color: #f3f4f6; }
html[data-bs-theme="dark"] .us-item:hover,
html[data-bs-theme="dark"] .us-item.active {
    background: rgba(129,140,248,0.1);
}
html[data-bs-theme="dark"] .us-item-visual {
    background: rgba(255,255,255,0.06);
}
html[data-bs-theme="dark"] .us-item-visual i { color: #9ca3af; }
html[data-bs-theme="dark"] .us-item-badge {
    background: rgba(255,255,255,0.06);
    color: #9ca3af;
}
html[data-bs-theme="dark"] .us-results-group:not(:last-child) {
    border-color: rgba(255,255,255,0.04);
}
html[data-bs-theme="dark"] .us-tag {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.08);
    color: #9ca3af;
}
html[data-bs-theme="dark"] .us-tag:hover,
html[data-bs-theme="dark"] .us-tag.active {
    background: rgba(129,140,248,0.12);
    color: #818cf8;
    border-color: rgba(129,140,248,0.25);
}
html[data-bs-theme="dark"] .us-spinner {
    border-color: rgba(255,255,255,0.06);
    border-top-color: #818cf8;
}
html[data-bs-theme="dark"] .us-modal-body {
    scrollbar-color: rgba(255,255,255,0.1) transparent;
}
html[data-bs-theme="dark"] .us-modal-body::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.1);
}

/* ─── Mobile trigger icon ─── */
.us-trigger-mobile {
    display: none;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background: rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 50%;
    color: #9ca3af;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.us-trigger-mobile:hover {
    background: rgba(0,0,0,0.08);
    color: #111;
}
html[data-bs-theme="dark"] .us-trigger-mobile {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.1);
    color: #9ca3af;
}
html[data-bs-theme="dark"] .us-trigger-mobile:hover {
    background: rgba(255,255,255,0.12);
    color: #f3f4f6;
}

/* ─── Absolute centering applied directly to the trigger ─── */
/* The trigger itself gets absolutely centered.
   .us-overlay is a SIBLING (not a child) of this element,
   so transform here does NOT affect the fixed overlay viewport positioning. */
.unified-search-trigger.us-nav-centered {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 1031;
    max-width: 520px;
    width: 100%;
}

/* Tablet: narrow down so pill doesn't overlap brand / toggler */
@media (max-width: 991.98px) {
    .unified-search-trigger.us-nav-centered {
        max-width: 280px;
    }
}

/* Mobile: shrink to the round icon button only */
@media (max-width: 575.98px) {
    .unified-search-trigger.us-nav-centered {
        max-width: 44px;
        width: 44px;
    }
}

/* ─── Trigger Desktop vs Mobile Adaptive display ─── */
.us-trigger-desktop {
    display: flex;
}
.us-trigger-mobile {
    display: none;
}

@media (max-width: 991.98px) {
    .us-trigger-kbd {
        display: none !important;
    }
}

@media (max-width: 575.98px) {
    .us-trigger-desktop {
        display: none !important;
    }
    .us-trigger-mobile {
        display: flex !important;
    }
}

@media (max-width: 768px) {
    .us-modal {
        width: 100%;
        max-width: none;
        border-radius: 0;
        height: 100vh;
        max-height: 100vh;
    }
    .us-overlay { padding-top: 0; }
    .us-modal-body { max-height: calc(100vh - 130px); }
}
</style>
@endonce

{{-- ============================================================
     Unified Search Script (one instance per component via uid)
     ============================================================ --}}
<script>
(function() {
    document.addEventListener('DOMContentLoaded', function () {
        const uid      = '{{ $uid }}';
        const endpoint = document.getElementById(uid + '_trigger').dataset.endpoint;

        const overlay   = document.getElementById(uid + '_overlay');
        const backdrop  = document.getElementById(uid + '_backdrop');
        const input     = document.getElementById(uid + '_input');
        const closeBtn  = document.getElementById(uid + '_close');
        const triggerBtn = document.getElementById(uid + '_btn');
        const idle      = document.getElementById(uid + '_idle');
        const loading   = document.getElementById(uid + '_loading');
        const results   = document.getElementById(uid + '_results');
        const noresults = document.getElementById(uid + '_noresults');
        const queryPh   = document.getElementById(uid + '_query_ph');

        if (!overlay || !input) return;

        let activeIndex = -1;
        let searchableItems = [];
        let debounceTimer;

        /* ── Open / Close ── */
        function open() {
            overlay.classList.add('active');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            setTimeout(() => input.focus(), 80);
        }

        function close() {
            overlay.classList.remove('active');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            input.value = '';
            reset();
        }

        function reset() {
            idle.style.display    = '';
            loading.style.display = 'none';
            results.style.display = 'none';
            results.innerHTML     = '';
            noresults.style.display = 'none';
            activeIndex = -1;
            searchableItems = [];
        }

        /* ── Search ── */
        async function search(query) {
            if (!query) { reset(); return; }

            idle.style.display    = 'none';
            loading.style.display = '';
            results.style.display = 'none';
            noresults.style.display = 'none';

            try {
                const res  = await fetch(`${endpoint}?query=${encodeURIComponent(query)}`);
                const data = await res.json();
                loading.style.display = 'none';
                render(data, query);
            } catch (e) {
                console.error('Search error:', e);
                loading.style.display = 'none';
            }
        }

        /* ── Render ── */
        function render(data, query) {
            results.innerHTML = '';
            searchableItems = [];
            let hasResults = false;

            for (const [key, items] of Object.entries(data)) {
                if (!items || items.length === 0) continue;
                hasResults = true;

                const group = document.createElement('div');
                group.className = 'us-results-group';

                const label = key.charAt(0).toUpperCase() + key.slice(1);
                group.innerHTML = `<div class="us-group-title">${label}</div>`;

                // Check if these are "tag-style" items (categories from blog)
                const isTagStyle = items.every(i => !i.image && !i.icon && !i.subtitle && !i.type);

                if (isTagStyle) {
                    const tagList = document.createElement('div');
                    tagList.className = 'us-tags-list';
                    items.forEach(item => {
                        const tag = document.createElement('a');
                        tag.className = 'us-tag';
                        tag.href = item.url || '#';
                        tag.textContent = item.title;
                        tag.addEventListener('click', (e) => {
                            e.preventDefault();
                            window.location.href = item.url;
                        });
                        tagList.appendChild(tag);
                        searchableItems.push(tag);
                    });
                    group.appendChild(tagList);
                } else {
                    const list = document.createElement('div');
                    list.className = 'us-group-list';

                    items.forEach(item => {
                        const el = document.createElement('a');
                        el.className = `us-item ${item.type ? 'type-' + item.type : ''}`;
                        el.href = item.url || '#';

                        const visualHtml = item.image
                            ? `<img src="${item.image}" alt="">`
                            : `<i class="${item.icon || 'fa-solid fa-circle-dot'}"></i>`;

                        el.innerHTML = `
                            <div class="us-item-visual">${visualHtml}</div>
                            <div class="us-item-info">
                                <div class="us-item-title-row">
                                    <div class="us-item-title">${item.title}</div>
                                    ${item.badge ? `<span class="us-item-badge">${item.badge}</span>` : ''}
                                </div>
                                ${item.subtitle || item.category ? `<div class="us-item-subtitle">${item.subtitle || item.category}</div>` : ''}
                            </div>
                        `;

                        el.addEventListener('click', (e) => {
                            e.preventDefault();
                            window.location.href = item.url;
                        });

                        list.appendChild(el);
                        searchableItems.push(el);
                    });

                    group.appendChild(list);
                }

                results.appendChild(group);
            }

            if (!hasResults) {
                results.style.display = 'none';
                queryPh.textContent = query;
                noresults.style.display = '';
            } else {
                results.style.display = '';
                noresults.style.display = 'none';
            }
            activeIndex = -1;
        }

        /* ── Keyboard Navigation ── */
        function setActive(index) {
            searchableItems.forEach(el => el.classList.remove('active'));
            if (index >= 0 && index < searchableItems.length) {
                searchableItems[index].classList.add('active');
                searchableItems[index].scrollIntoView({ block: 'nearest' });
                activeIndex = index;
            }
        }

        input.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            const q = this.value.trim();
            debounceTimer = setTimeout(() => search(q), 280);
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { close(); return; }
            if (!searchableItems.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = (activeIndex + 1) % searchableItems.length;
                setActive(activeIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = (activeIndex - 1 + searchableItems.length) % searchableItems.length;
                setActive(activeIndex);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (activeIndex >= 0 && searchableItems[activeIndex]) {
                    searchableItems[activeIndex].click();
                }
            }
        });

        /* ── Event bindings ── */
        triggerBtn.addEventListener('click', open);
        const mobileBtn = document.getElementById(uid + '_btn_mobile');
        if (mobileBtn) mobileBtn.addEventListener('click', open);
        backdrop.addEventListener('click', close);
        closeBtn.addEventListener('click', close);

        /* ── Double-Shift trigger ── */
        let lastShift = 0, shiftCount = 0;
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Shift' && !e.ctrlKey && !e.altKey && !e.metaKey) {
                const now = Date.now();
                shiftCount = (now - lastShift < 400) ? shiftCount + 1 : 1;
                lastShift = now;
                if (shiftCount >= 2) {
                    shiftCount = 0;
                    overlay.classList.contains('active') ? close() : open();
                }
            } else {
                shiftCount = 0;
            }
        });
    });
})();
</script>
