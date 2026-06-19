//Node_modules plugins
import 'bootstrap';
import Lenis from 'lenis';

//Components
import './components/loader'
import { showAuthModal } from './components/modal';
import { initSelects } from './components/select';
import { initUserProfileDropdown } from './components/user-profile-dropdown.js';
import { initSearches } from './components/search.js';

//DOM
document.addEventListener('DOMContentLoaded', () => {
    window.lenis = new Lenis({
        autoRaf: true,
    });

    // Initializations components
    window.showAuthModal = showAuthModal;
    initSelects();
    initUserProfileDropdown();
    initSearches();
});
