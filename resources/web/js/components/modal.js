export function showAuthModal() {
    const el = document.getElementById('authRequiredModal');
    if (!el) return;

    el.classList.add('modal-window--open');
    document.body.style.overflow = 'hidden';
}

export function hideAuthModal() {
    const el = document.getElementById('authRequiredModal');
    if (!el) return;

    el.classList.remove('modal-window--open');
    document.body.style.overflow = '';
}

// Attach event listeners for closing
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('authRequiredModal');
    if (!el) return;

    const closeButtons = el.querySelectorAll('[data-close-modal]');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', hideAuthModal);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && el.classList.contains('modal-window--open')) {
            hideAuthModal();
        }
    });
});
