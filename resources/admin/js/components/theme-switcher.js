export default class ThemeSwitcher {
    constructor() {
        this.themeSwitcher = document.querySelector("#bd-theme");
        this.themeSwitcherText = document.querySelector("#bd-theme-text");
        this.activeThemeIcon = document.querySelector(".theme-icon-active i");

        this.init();
    }

    getPreferredTheme() {
        const storedTheme = localStorage.getItem("theme");
        if (storedTheme) return storedTheme;
        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    }

    setTheme(theme) {
        const targetTheme = theme === "auto" && window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : theme;
        document.documentElement.setAttribute("data-bs-theme", targetTheme);
    }

    showActiveTheme(theme, focus = false) {
        if (!this.themeSwitcher) return;

        const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);
        const iconClass = btnToActive.querySelector("i").getAttribute("class");

        document.querySelectorAll("[data-bs-theme-value]").forEach(element => {
            element.classList.remove("active");
            element.setAttribute("aria-pressed", "false");
        });

        btnToActive.classList.add("active");
        btnToActive.setAttribute("aria-pressed", "true");
        this.activeThemeIcon.setAttribute("class", iconClass);

        if (focus) this.themeSwitcher.focus();
    }

    init() {
        const theme = this.getPreferredTheme();
        this.setTheme(theme);
        this.showActiveTheme(theme);

        window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
            const storedTheme = localStorage.getItem("theme");
            if (storedTheme !== "light" && storedTheme !== "dark") {
                this.setTheme(this.getPreferredTheme());
            }
        });

        document.querySelectorAll("[data-bs-theme-value]").forEach(toggle => {
            toggle.addEventListener("click", () => {
                const theme = toggle.getAttribute("data-bs-theme-value");
                localStorage.setItem("theme", theme);
                this.setTheme(theme);
                this.showActiveTheme(theme, true);
            });
        });
    }
}
