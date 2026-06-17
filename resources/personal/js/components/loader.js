window.addEventListener('load', () => {
    const loader = document.querySelector('.app-loader');

    loader?.classList.add('app-loader--hidden');

    loader?.addEventListener('transitionend', () => {
        loader.remove();
    });
});
