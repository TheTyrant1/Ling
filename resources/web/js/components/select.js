function initSortSelect(el) {
    const native = el.querySelector('.sort-select__native');
    const trigger = el.querySelector('.sort-select__trigger');
    const menu = el.querySelector('.sort-select__menu');
    const text = el.querySelector('.sort-select__text');
    const options = el.querySelectorAll('.sort-select__option');

    if (!native || !trigger || !menu || !text) return;

    let highlightedIndex = -1;

    function getSelectableOptions() {
        return [...options];
    }

    function updateSelected(value) {
        native.value = value;

        options.forEach((opt) => {
            const selected = opt.dataset.value === value;
            opt.classList.toggle('sort-select__option--selected', selected);
            opt.setAttribute('aria-selected', selected ? 'true' : 'false');
        });

        const selectedOpt = native.options[native.selectedIndex];
        text.textContent = selectedOpt?.textContent ?? '';
    }

    function open() {
        el.classList.add('sort-select--open');
        trigger.setAttribute('aria-expanded', 'true');
        highlightedIndex = getSelectableOptions().findIndex((opt) =>
            opt.classList.contains('sort-select__option--selected')
        );
        setHighlighted(highlightedIndex);
    }

    function close() {
        el.classList.remove('sort-select--open');
        trigger.setAttribute('aria-expanded', 'false');
        clearHighlight();
        highlightedIndex = -1;
    }

    function setHighlighted(index) {
        getSelectableOptions().forEach((opt, i) => {
            opt.classList.toggle('sort-select__option--highlighted', i === index);
        });

        const items = getSelectableOptions();
        if (index >= 0 && items[index]) {
            items[index].scrollIntoView({ block: 'nearest' });
        }
    }

    function clearHighlight() {
        options.forEach((opt) => {
            opt.classList.remove('sort-select__option--highlighted');
        });
    }

    function selectValue(value) {
        updateSelected(value);
        close();
        native.dispatchEvent(new Event('change', { bubbles: true }));

        const form = native.closest('form');
        if (form) {
            form.requestSubmit?.() ?? form.submit();
        }
    }

    function handleKeydown(e) {
        const items = getSelectableOptions();
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (!el.classList.contains('sort-select--open')) {
                open();
                return;
            }
            highlightedIndex = (highlightedIndex + 1) % items.length;
            setHighlighted(highlightedIndex);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (!el.classList.contains('sort-select--open')) {
                open();
                highlightedIndex = items.length - 1;
                setHighlighted(highlightedIndex);
                return;
            }
            highlightedIndex = (highlightedIndex - 1 + items.length) % items.length;
            setHighlighted(highlightedIndex);
        } else if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if (!el.classList.contains('sort-select--open')) {
                open();
            } else if (highlightedIndex >= 0 && items[highlightedIndex]) {
                selectValue(items[highlightedIndex].dataset.value);
            }
        } else if (e.key === 'Escape') {
            close();
        }
    }

    options.forEach((opt) => {
        opt.addEventListener('click', () => {
            selectValue(opt.dataset.value);
        });
    });

    trigger.addEventListener('click', () => {
        el.classList.contains('sort-select--open') ? close() : open();
    });

    trigger.addEventListener('keydown', handleKeydown);

    document.addEventListener('click', (e) => {
        if (!el.contains(e.target)) {
            close();
        }
    });

    updateSelected(native.value);
}

function initProfileSelect(el) {
    const trigger = el.querySelector('.profile-select__trigger');
    const menu = el.querySelector('.profile-select__menu');

    if (!trigger || !menu) return;

    function open() {
        el.classList.add('profile-select--open');
        trigger.setAttribute('aria-expanded', 'true');
    }

    function close() {
        el.classList.remove('profile-select--open');
        trigger.setAttribute('aria-expanded', 'false');
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        el.classList.contains('profile-select--open') ? close() : open();
    });

    document.addEventListener('click', (e) => {
        if (!el.contains(e.target)) {
            close();
        }
    });

    trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            el.classList.contains('profile-select--open') ? close() : open();
        } else if (e.key === 'Escape') {
            close();
        }
    });
}

export function initSelects() {
    document.querySelectorAll('.sort-select').forEach(initSortSelect);
    document.querySelectorAll('.profile-select').forEach(initProfileSelect);
}
