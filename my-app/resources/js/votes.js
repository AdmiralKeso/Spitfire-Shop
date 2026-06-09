// Event delegation — handles vote forms added dynamically by topic filtering
document.addEventListener('submit', async function(e) {
    const form = e.target.closest('.vote-form');
    if (!form) return;
    e.preventDefault();
    const postId = form.dataset.postId;
    const res = await fetch(form.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: new FormData(form),
    });
    const data = await res.json();
    const up   = document.getElementById('upvote-'   + postId);
    const down = document.getElementById('downvote-' + postId);
    up.querySelector('span').textContent   = data.upvotes;
    down.querySelector('span').textContent = data.downvotes;
    up.classList.toggle('vote-btn-active',   data.userVote === 1);
    down.classList.toggle('vote-btn-active', data.userVote === -1);
});
