//Imports
import '../css/styles.css';
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
