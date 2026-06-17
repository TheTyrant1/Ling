//Node_modules plugins
import "bootstrap";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import Lenis from 'lenis';

//Scss
import "../scss/app.scss";

//Utils
import { onDOMContentLoaded } from './util';
import './util/bootstrap.js';

// Components
import './components/loader';
import Layout from './components/layout';
import PushMenu from './components/push-menu';
import ThemeSwitcher from './components/theme-switcher.js';
import ProfileImageUploader from "./components/profile-image-uploader.js";
import ProfileImageUpdate from './components/profile-image-update';


// Executes initialization logic once the DOM is fully loaded.
onDOMContentLoaded(() => {
    // Initializations node_modules plugins
    const el = document.getElementById("editor");
    if (el) {
        const quill = new Quill(el, {
            theme: "snow",
            placeholder: 'Enter post content',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ["bold", "italic", "underline"],
                    [{ list: "ordered" }, { list: "bullet" }],
                    ["link"],
                    ["clean"]
                ]
            }
        });

        // Sync Quill content with a hidden input before form submission
        const form = el.closest("form");
        if (form) {
            form.addEventListener("submit", () => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "content";
                input.value = quill.root.innerHTML;
                form.appendChild(input);
            });
        }
    }

    const lenis = new Lenis({
        autoRaf: true,
    });

    // Initializations JS Components
    const uploaders = document.querySelectorAll('[data-component="avatar-uploader"]');
    uploaders.forEach(element => {
        new ProfileImageUploader(element);
    });

    // Profile image preview logic
    new ProfileImageUpdate('avatarInput', 'avatarPreview');

    // Dark/Light theme toggle logic
    new ThemeSwitcher();

    // Core layout and sidebar functionality
    new Layout();
    new PushMenu();
});

// Exporting components for potential external usage
export { Layout, PushMenu };
