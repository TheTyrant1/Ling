import Lenis from 'lenis';

const SEARCH_SELECTOR = '[data-search]';
const ACTIVE_OVERLAY_CLASS = 'search__overlay--active';
const ACTIVE_RESULT_CLASS = 'search__result--active';
const ACTIVE_TAG_CLASS = 'search__tag--active';
const LOCK_CLASS = 'search-is-open';

function setHidden(element, hidden) {
    if (element) {
        element.hidden = hidden;
    }
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function createResultItem(item) {
    const link = document.createElement('a');
    link.className = `search__result ${item.type ? `search__result--${item.type}` : ''}`;
    link.href = item.url || '#';

    const visualHtml = item.image
        ? `<img src="${escapeHtml(item.image)}" alt="">`
        : `<i class="${escapeHtml(item.icon || 'fa-solid fa-circle-dot')}"></i>`;

    link.innerHTML = `
        <div class="search__result-visual">${visualHtml}</div>
        <div class="search__result-info">
            <div class="search__result-title-row">
                <div class="search__result-title">${escapeHtml(item.title)}</div>
                ${item.badge ? `<span class="search__result-badge">${escapeHtml(item.badge)}</span>` : ''}
            </div>
            ${item.subtitle || item.category ? `<div class="search__result-subtitle">${escapeHtml(item.subtitle || item.category)}</div>` : ''}
        </div>
    `;

    link.addEventListener('click', (event) => {
        if (!item.url) {
            return;
        }

        event.preventDefault();
        window.location.href = item.url;
    });

    return link;
}

function initSearch(root) {
    if (root.dataset.searchReady === 'true') {
        return;
    }

    root.dataset.searchReady = 'true';

    const uid = root.dataset.searchUid;
    const endpoint = root.dataset.searchEndpoint || '/search';
    const overlay = document.getElementById(`${uid}_overlay`);
    const modal = overlay?.querySelector('.search__modal');
    const backdrop = document.getElementById(`${uid}_backdrop`);
    const input = document.getElementById(`${uid}_input`);
    const closeBtn = document.getElementById(`${uid}_close`);
    const triggerBtn = document.getElementById(`${uid}_trigger`);
    const mobileBtn = document.getElementById(`${uid}_trigger_mobile`);
    const idle = document.getElementById(`${uid}_idle`);
    const loading = document.getElementById(`${uid}_loading`);
    const results = document.getElementById(`${uid}_results`);
    const empty = document.getElementById(`${uid}_empty`);
    const queryText = document.getElementById(`${uid}_query`);

    if (!uid || !overlay || !backdrop || !input || !closeBtn || !triggerBtn || !results) {
        return;
    }

    document.body.appendChild(overlay);

    let activeIndex = -1;
    let searchableItems = [];
    let debounceTimer;
    let abortController;
    let scrollY = 0;
    let modalLenis = null;

    function getSearchBody() {
        return modal?.querySelector('.search__body');
    }

    function startModalLenis() {
        const body = getSearchBody();

        if (!body || modalLenis) {
            return;
        }

        modalLenis = new Lenis({
            wrapper: body,
            content: body,
            eventsTarget: overlay,
            autoRaf: true,
        });
    }

    function stopModalLenis() {
        if (!modalLenis) {
            return;
        }

        modalLenis.destroy();
        modalLenis = null;
    }

    function scrollToItem(element) {
        if (modalLenis) {
            modalLenis.scrollTo(element, { offset: -8, lock: false });
            return;
        }

        element.scrollIntoView({ block: 'nearest' });
    }

    function reset() {
        setHidden(idle, false);
        setHidden(loading, true);
        setHidden(results, true);
        setHidden(empty, true);
        results.innerHTML = '';
        activeIndex = -1;
        searchableItems = [];
    }

    function lockPageScroll() {
        scrollY = window.scrollY || document.documentElement.scrollTop;
        document.documentElement.classList.add(LOCK_CLASS);
        document.body.classList.add(LOCK_CLASS);
        document.body.style.top = `-${scrollY}px`;
        window.lenis?.stop?.();
    }

    function unlockPageScroll() {
        document.documentElement.classList.remove(LOCK_CLASS);
        document.body.classList.remove(LOCK_CLASS);
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
        window.lenis?.start?.();
    }

    function open() {
        if (overlay.classList.contains(ACTIVE_OVERLAY_CLASS)) {
            return;
        }

        overlay.classList.add(ACTIVE_OVERLAY_CLASS);
        overlay.setAttribute('aria-hidden', 'false');
        lockPageScroll();
        startModalLenis();
        window.setTimeout(() => input.focus(), 80);
    }

    function close() {
        if (!overlay.classList.contains(ACTIVE_OVERLAY_CLASS)) {
            return;
        }

        overlay.classList.remove(ACTIVE_OVERLAY_CLASS);
        overlay.setAttribute('aria-hidden', 'true');
        input.value = '';
        abortController?.abort();
        window.clearTimeout(debounceTimer);
        reset();
        stopModalLenis();
        unlockPageScroll();
    }

    function setActive(index) {
        searchableItems.forEach((element) => {
            element.classList.remove(ACTIVE_RESULT_CLASS, ACTIVE_TAG_CLASS);
        });

        if (index >= 0 && index < searchableItems.length) {
            const activeClass = searchableItems[index].classList.contains('search__tag')
                ? ACTIVE_TAG_CLASS
                : ACTIVE_RESULT_CLASS;

            searchableItems[index].classList.add(activeClass);
            scrollToItem(searchableItems[index]);
            activeIndex = index;
        }
    }

    function render(data, query) {
        results.innerHTML = '';
        searchableItems = [];

        let hasResults = false;

        Object.entries(data || {}).forEach(([key, items]) => {
            if (!Array.isArray(items) || items.length === 0) {
                return;
            }

            hasResults = true;

            const group = document.createElement('div');
            group.className = 'search__results-group';

            const title = document.createElement('div');
            title.className = 'search__group-title';
            title.textContent = key.charAt(0).toUpperCase() + key.slice(1);
            group.appendChild(title);

            const isTagStyle = key === 'tags' || items.every((item) => item.type === 'tag');

            if (isTagStyle) {
                const tagList = document.createElement('div');
                tagList.className = 'search__tags';

                items.forEach((item) => {
                    const tag = document.createElement('a');
                    tag.className = 'search__tag';
                    tag.href = item.url || '#';
                    tag.textContent = item.title || '';
                    tag.addEventListener('click', (event) => {
                        if (!item.url) {
                            return;
                        }

                        event.preventDefault();
                        window.location.href = item.url;
                    });

                    tagList.appendChild(tag);
                    searchableItems.push(tag);
                });

                group.appendChild(tagList);
            } else {
                const list = document.createElement('div');
                list.className = 'search__group-list';

                items.forEach((item) => {
                    const resultItem = createResultItem(item);
                    list.appendChild(resultItem);
                    searchableItems.push(resultItem);
                });

                group.appendChild(list);
            }

            results.appendChild(group);
        });

        if (!hasResults) {
            setHidden(results, true);
            if (queryText) {
                queryText.textContent = query;
            }
            setHidden(empty, false);
        } else {
            setHidden(results, false);
            setHidden(empty, true);
        }

        activeIndex = -1;
        modalLenis?.resize?.();
    }

    async function search(query) {
        if (!query) {
            abortController?.abort();
            reset();
            return;
        }

        abortController?.abort();
        abortController = new AbortController();

        setHidden(idle, true);
        setHidden(loading, false);
        setHidden(results, true);
        setHidden(empty, true);

        try {
            const url = new URL(endpoint, window.location.origin);
            url.searchParams.set('query', query);

            const response = await fetch(url, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                signal: abortController.signal,
            });

            if (!response.ok) {
                throw new Error(`Search request failed with status ${response.status}`);
            }

            const data = await response.json();
            setHidden(loading, true);
            render(data, query);
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            console.error('Search error:', error);
            setHidden(loading, true);
            render({}, query);
        }
    }

    input.addEventListener('input', () => {
        window.clearTimeout(debounceTimer);
        debounceTimer = window.setTimeout(() => search(input.value.trim()), 280);
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
            return;
        }

        if (!searchableItems.length) {
            return;
        }

        if (event.key === 'ArrowDown') {
            event.preventDefault();
            setActive((activeIndex + 1) % searchableItems.length);
        }

        if (event.key === 'ArrowUp') {
            event.preventDefault();
            setActive((activeIndex - 1 + searchableItems.length) % searchableItems.length);
        }

        if (event.key === 'Enter' && activeIndex >= 0) {
            event.preventDefault();
            searchableItems[activeIndex].click();
        }
    });

    triggerBtn.addEventListener('click', open);
    mobileBtn?.addEventListener('click', open);
    backdrop.addEventListener('click', close);
    closeBtn.addEventListener('click', close);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && overlay.classList.contains(ACTIVE_OVERLAY_CLASS)) {
            close();
        }
    });

    let lastShift = 0;
    let shiftCount = 0;

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Shift' || event.ctrlKey || event.altKey || event.metaKey) {
            shiftCount = 0;
            return;
        }

        const now = Date.now();
        shiftCount = now - lastShift < 400 ? shiftCount + 1 : 1;
        lastShift = now;

        if (shiftCount >= 2) {
            shiftCount = 0;
            overlay.classList.contains(ACTIVE_OVERLAY_CLASS) ? close() : open();
        }
    });
}

export function initSearches() {
    document.querySelectorAll(SEARCH_SELECTOR).forEach(initSearch);
}
