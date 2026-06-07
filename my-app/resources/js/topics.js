const topicLinks   = document.querySelectorAll('.topic-item');
const postsList    = document.getElementById('posts-list');
const paginationEl = document.getElementById('posts-pagination');
const PER_PAGE     = 8;
let currentPage    = 1;

function esc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function showPage(page) {
    if (!postsList) return;
    const items      = Array.from(postsList.querySelectorAll('.forum-post-item'));
    const totalPages = Math.max(1, Math.ceil(items.length / PER_PAGE));
    currentPage      = Math.max(1, Math.min(page, totalPages));

    const start = (currentPage - 1) * PER_PAGE;
    items.forEach((item, i) => {
        item.style.display = (i >= start && i < start + PER_PAGE) ? '' : 'none';
    });

    renderPaginationBtns(items.length);
}

function renderPaginationBtns(total) {
    if (!paginationEl) return;
    const totalPages = Math.ceil(total / PER_PAGE);
    if (totalPages <= 1) { paginationEl.innerHTML = ''; return; }

    let html = `<button class="page-btn" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}>&#8249;</button>`;
    for (let i = 1; i <= totalPages; i++) {
        html += `<button class="page-btn${i === currentPage ? ' page-btn-active' : ''}" data-page="${i}">${i}</button>`;
    }
    html += `<button class="page-btn" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''}>&#8250;</button>`;

    paginationEl.innerHTML = html;
    paginationEl.querySelectorAll('.page-btn:not([disabled])').forEach(btn => {
        btn.addEventListener('click', () => showPage(parseInt(btn.dataset.page)));
    });
}
