export function initUserProfileDropdown() {
    const avatarBtn = document.getElementById('avatarBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    if (!avatarBtn || !dropdownMenu) {
        return;
    }

    avatarBtn.addEventListener('click', (event) => {
        event.stopPropagation();
        dropdownMenu.classList.toggle('user-profile__dropdown--open');
    });

    dropdownMenu.addEventListener('click', (event) => {
        event.stopPropagation();
    });

    window.addEventListener('click', (event) => {
        if (!avatarBtn.contains(event.target)) {
            dropdownMenu.classList.remove('user-profile__dropdown--open');
        }
    });
}
