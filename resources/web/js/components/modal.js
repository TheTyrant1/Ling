export function showAuthModal() {
    const el = document.getElementById('authRequiredModal');

    if (!el) return;

    const modal = new bootstrap.Modal(el);
    modal.show();
}
