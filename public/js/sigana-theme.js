(function () {
    const storageKey = 'sigana-theme';
    const root = document.documentElement;

    let savedTheme = 'light';
    try {
        savedTheme = sessionStorage.getItem(storageKey) || 'light';
    } catch (error) {
        savedTheme = 'light';
    }

    function applyTheme(theme) {
        const isDark = theme === 'dark';
        root.dataset.theme = isDark ? 'dark' : 'light';
        root.style.colorScheme = isDark ? 'dark' : 'light';

        const button = document.querySelector('[data-sigana-theme-toggle]');
        if (button) {
            button.setAttribute('aria-pressed', String(isDark));
            button.setAttribute('aria-label', isDark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap');
            button.innerHTML = `<span class="sigana-theme-toggle-icon" aria-hidden="true">${isDark ? '☀️' : '🌙'}</span><span>${isDark ? 'Mode terang' : 'Mode gelap'}</span>`;
        }
    }

    applyTheme(savedTheme);

    function addToggle() {
        if (document.querySelector('[data-sigana-theme-toggle]')) return;
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'sigana-theme-toggle';
        button.dataset.siganaThemeToggle = '';
        button.addEventListener('click', function () {
            const nextTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';
            try {
                sessionStorage.setItem(storageKey, nextTheme);
            } catch (error) {
                // The selected theme still applies for this page if storage is unavailable.
            }
            applyTheme(nextTheme);
        });
        document.body.appendChild(button);
        applyTheme(root.dataset.theme || 'light');
    }

    function addPageLoader() {
        if (document.getElementById('sigana-page-loader')) return;

        const loader = document.createElement('div');
        loader.id = 'sigana-page-loader';
        loader.setAttribute('role', 'status');
        loader.setAttribute('aria-live', 'polite');
        loader.setAttribute('aria-label', 'Sedang memuat halaman SIGANA');
        loader.innerHTML = `
            <div class="sigana-loader-card">
                <div class="sigana-loader-orbit" aria-hidden="true">
                    <span class="sigana-loader-glow"></span>
                    <span class="sigana-loader-core">S</span>
                </div>
                <strong>SIGANA</strong>
                <span class="sigana-loader-caption">Menyiapkan halaman...</span>
                <span class="sigana-loader-track" aria-hidden="true"><i></i></span>
            </div>`;
        document.body.appendChild(loader);

        let showTimer;
        let isNavigating = false;
        const hide = () => {
            window.clearTimeout(showTimer);
            isNavigating = false;
            loader.classList.remove('is-visible');
            loader.setAttribute('aria-hidden', 'true');
        };

        loader.setAttribute('aria-hidden', 'true');
        document.addEventListener('click', (event) => {
            if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
            const link = event.target.closest('a[href]');
            if (!link || link.hasAttribute('download') || link.target === '_blank') return;

            let destination;
            try { destination = new URL(link.href, window.location.href); } catch (error) { return; }
            if (destination.origin !== window.location.origin) return;
            if (destination.pathname === window.location.pathname && destination.search === window.location.search) return;

            isNavigating = true;
            showTimer = window.setTimeout(() => {
                if (!isNavigating) return;
                loader.setAttribute('aria-hidden', 'false');
                loader.classList.add('is-visible');
            }, 110);
        });

        window.addEventListener('pageshow', hide);
        window.addEventListener('pagehide', () => window.clearTimeout(showTimer));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            addToggle();
            addPageLoader();
        }, { once: true });
    } else {
        addToggle();
        addPageLoader();
    }
})();
