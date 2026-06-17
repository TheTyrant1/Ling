//Node_modules plugins
import 'bootstrap';
import Lenis from 'lenis';

//Components
import './components/loader'
import { showAuthModal } from './components/modal';
import { initSelects } from './components/select';

//DOM
document.addEventListener('DOMContentLoaded', () => {
    // Initializations node_modules plugins
    const lenis = new Lenis({
        autoRaf: true,
    });

    // Initializations components
    window.showAuthModal = showAuthModal;
    initSelects();
});
