const CONSENT_KEY = 'cookie_consent';

function createCookieConsent() {
    const consent = document.createElement('div');
    consent.className = 'cookie-consent';
    consent.id = 'cookieConsent';
    consent.innerHTML = `
        <div class="cookie-consent__container">
            <p class="cookie-consent__text">
                We use cookies to improve your experience on our site. By continuing, you agree to our use of cookies.
            </p>
            <div class="cookie-consent__actions">
                <button type="button" class="cookie-consent__btn cookie-consent__btn--decline">
                    Decline
                </button>
                <button type="button" class="cookie-consent__btn cookie-consent__btn--accept">
                    Accept
                </button>
            </div>
        </div>
    `;

    return consent;
}

function hideCookieConsent(consent, animated) {
    if (!consent) {
        return;
    }

    if (!animated) {
        consent.remove();
        return;
    }

    consent.classList.add('cookie-consent--hidden');

    consent.addEventListener('transitionend', () => {
        consent.remove();
    }, { once: true });
}

export function initCookieConsent() {
    if (document.body.dataset.cookieConsent !== 'true') {
        return;
    }

    if (localStorage.getItem(CONSENT_KEY)) {
        return;
    }

    const consent = createCookieConsent();
    document.body.appendChild(consent);

    const acceptBtn = consent.querySelector('.cookie-consent__btn--accept');
    const declineBtn = consent.querySelector('.cookie-consent__btn--decline');

    if (acceptBtn) {
        acceptBtn.addEventListener('click', () => {
            localStorage.setItem(CONSENT_KEY, 'accepted');
            hideCookieConsent(consent, true);
        });
    }

    if (declineBtn) {
        declineBtn.addEventListener('click', () => {
            localStorage.setItem(CONSENT_KEY, 'declined');
            hideCookieConsent(consent, true);
        });
    }
}
