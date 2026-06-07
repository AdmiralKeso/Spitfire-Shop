//Imports
import '../css/styles.css';
import './votes.js';
import './topics.js';

const spinner = document.getElementById('page-spinner');

// window flag survives Vite HMR re-execution and async chunk loads
//Spinner is declared in the HTML so that it can be shown immediately, before this script loads. Because VITE is async
if (!window.__spinnerInit) {
    window.__spinnerInit = true;
    window.addEventListener('load', () => {
        document.fonts.ready.then(() => { if (spinner) spinner.style.display = 'none'; });
    });
}

document.addEventListener('click', function (e) {
    const link = e.target.closest('a');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto') || href.startsWith('tel') || link.target === '_blank') return;
    if (spinner) spinner.style.display = 'flex';
});

document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger-btn');
    const drawer = document.getElementById('nav-drawer');
    const overlay = document.getElementById('nav-overlay');
    const closeBtn = document.getElementById('drawer-close');

    if (!hamburger) return;

    function openDrawer() {
        drawer.classList.add('open');
        overlay.classList.add('open');
    }
    function closeDrawer() {
        drawer.classList.remove('open');
        overlay.classList.remove('open');
    }

    hamburger.addEventListener('click', openDrawer);
    closeBtn.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
});
