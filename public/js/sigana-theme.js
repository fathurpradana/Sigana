(function () {
    const storageKey = 'sigana-theme';
    const root = document.documentElement;

    let savedTheme = 'light';
    try {
        savedTheme = localStorage.getItem(storageKey) || 'light';
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
                localStorage.setItem(storageKey, nextTheme);
            } catch (error) {
                // The selected theme still applies for this page if storage is unavailable.
            }
            applyTheme(nextTheme);
        });
        document.body.appendChild(button);
        applyTheme(root.dataset.theme || 'light');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', addToggle, { once: true });
    } else {
        addToggle();
    }
})();