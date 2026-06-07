export function makeVoteForm(p, vote, csrf, isGuest, accountUrl) {
    const isUp = vote === 1;

    const btn = document.createElement('button');
    btn.id = (isUp ? 'upvote-' : 'downvote-') + p.id;
    btn.className = 'vote-btn' + (p.user_vote === vote ? ' vote-btn-active' : '');
    if (isGuest) {
        btn.type = 'button';
        btn.addEventListener('click', () => { window.location = accountUrl; });
    } else {
        btn.type = 'submit';
    }
    btn.append(isUp ? '👍 ' : '👎 ');
    const countSpan = document.createElement('span');
    countSpan.textContent = isUp ? p.upvotes : p.downvotes;
    btn.appendChild(countSpan);

    const form = document.createElement('form');
    form.className = 'vote-form';
    form.method = 'POST';
    form.action = p.vote_url;
    form.dataset.postId = p.id;

    const tokenInput = document.createElement('input');
    tokenInput.type  = 'hidden';
    tokenInput.name  = '_token';
    tokenInput.value = csrf;

    const voteInput = document.createElement('input');
    voteInput.type  = 'hidden';
    voteInput.name  = 'vote';
    voteInput.value = vote;

    form.append(tokenInput, voteInput, btn);
    return form;
}

export function renderPost(p, csrf, isGuest, accountUrl) {
    const titleSpan = document.createElement('span');
    titleSpan.className   = 'forum-post-title';
    titleSpan.textContent = p.title;

    const authorSpan = document.createElement('span');
    authorSpan.className   = 'forum-post-author';
    authorSpan.textContent = 'by ' + p.user_name;

    const genreSpan = document.createElement('span');
    genreSpan.className   = 'forum-post-genre';
    genreSpan.textContent = p.genre;

    const header = document.createElement('div');
    header.className = 'forum-post-header';
    header.append(titleSpan, authorSpan, genreSpan);

    const desc = document.createElement('p');
    desc.className   = 'forum-post-desc';
    desc.textContent = p.description;

    const post = document.createElement('div');
    post.className = 'forum-post';
    post.append(header, desc);

    const link = document.createElement('a');
    link.href      = p.url;
    link.className = 'forum-post-link';
    link.appendChild(post);

    const commentCount = document.createElement('span');
    commentCount.className   = 'forum-post-comment-count';
    commentCount.textContent = '💬 ' + p.comments_count;

    const actions = document.createElement('div');
    actions.className = 'forum-post-actions';
    actions.append(
        makeVoteForm(p,  1, csrf, isGuest, accountUrl),
        makeVoteForm(p, -1, csrf, isGuest, accountUrl),
        commentCount,
    );

    const item = document.createElement('div');
    item.className = 'forum-post-item';
    item.append(link, actions);
    return item;
}
