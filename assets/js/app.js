document.addEventListener('DOMContentLoaded', () => {
    const glow = document.getElementById('cursorGlow');
    document.addEventListener('pointermove', (e) => {
        if (glow) {
            glow.style.left = `${e.clientX}px`;
            glow.style.top = `${e.clientY}px`;
        }
    });

    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('pcscms-theme') || 'dark';
    document.documentElement.dataset.theme = savedTheme;

    const updateThemeButton = () => {
        if (!themeToggle) return;
        const icon = themeToggle.querySelector('i');
        const text = themeToggle.querySelector('span');
        const light = document.documentElement.dataset.theme === 'light';
        if (icon) icon.className = light ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        if (text) text.textContent = light ? 'Light' : 'Dark';
    };

    updateThemeButton();

    themeToggle?.addEventListener('click', () => {
        const next = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
        document.documentElement.dataset.theme = next;
        localStorage.setItem('pcscms-theme', next);
        updateThemeButton();
    });

    const clock = document.getElementById('liveDateTime');
    const tick = () => {
        if (!clock) return;
        const now = new Date();
        clock.textContent = now.toLocaleString([], {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit'
        });
    };
    tick();
    setInterval(tick, 1000);

    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('mobileSidebarBackdrop');
    const open = document.getElementById('sidebarOpenBtn');
    const close = document.getElementById('sidebarCloseBtn');

    const hideSidebar = () => {
        sidebar?.classList.remove('show');
        backdrop?.classList.remove('show');
    };
    open?.addEventListener('click', () => {
        sidebar?.classList.add('show');
        backdrop?.classList.add('show');
    });
    close?.addEventListener('click', hideSidebar);
    backdrop?.addEventListener('click', hideSidebar);
});
