<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spitfire Shop</title>
    @vite(['resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            border-top: solid 0.5vw #7c7c00;
        }
        .main-logo { width: 4vw; }
        @media (max-width: 1100px) { .main-logo { width: 5vw; } }
        @media (max-width: 700px)  { .main-logo { width: 10vw; } }
        #page-spinner { position: fixed; inset: 0; background: #fff; z-index: 9999; display: flex; align-items: center; justify-content: center; }
        .page-spinner-wheel { width: 48px; height: 48px; border: 5px solid #e0e0e0; border-top-color: #7c7c00; border-radius: 50%; animation: spin 0.75s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>

<body>
    <div id="page-spinner"><div class="page-spinner-wheel"></div></div>
    <header class="main-header">
        <a href="{{ route('home') }}" class="main-title">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Spitfire logo" class="main-logo">
            <div id="head-title">
            <h1>The <span style="color: rgb(255, 144, 25);">History</span> Forum</h1>
            <p>Encyclopedia | Merch | Forum</p>
            </div>
        </a>
        <div id="menu-items">
            <a class="item" href="{{ route('home') }}" style="text-decoration: underline;">Home</a>
            <a class="item">Gallery</a>
            <a class="item" href="https://shop.iwm.org.uk/collections/spitfire-clothing?srsltid=AfmBOoo-qoiJBwa1YP_qm4jPLXe5HnED7MspYuSpKVtRNtLR2jFDrpOj" target="_blank">Merch</a>
            <a class="item" href="{{ route('forum') }}">Forum</a>
            <a class="item" href="{{ route('account') }}">Account</a>
        </div>
        <button class="hamburger" id="hamburger-btn" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </header>
    <div class="nav-overlay" id="nav-overlay"></div>
    <nav class="nav-drawer" id="nav-drawer">
        <button class="drawer-close" id="drawer-close" aria-label="Close menu">&#x2715;</button>
        <a class="drawer-item" href="{{ route('home') }}">Home</a>
        <a class="drawer-item">Gallery</a>
        <a class="drawer-item" href="https://shop.iwm.org.uk/collections/spitfire-clothing?srsltid=AfmBOoo-qoiJBwa1YP_qm4jPLXe5HnED7MspYuSpKVtRNtLR2jFDrpOj" target="_blank">Merch</a>
        <a class="drawer-item" href="{{ route('forum') }}">Forum</a>
        <a class="drawer-item" href="{{ route('account') }}">Account</a>
    </nav>

<section class="forum-mid-section" id="point">
    <div class="side-card">
        <h2 class="side-card-title">Browse by topic</h2>
        <a href="{{ route('forum') }}" class="topic-item {{ !$genre && !$filter ? 'topic-item-active' : '' }}">All posts</a>
        <p class="side-card-group">World history</p>
        @foreach (['General History','European History','Asian History','North American History','South American History'] as $g)
            <a href="{{ route('forum', ['genre' => $g]) }}" class="topic-item {{ $genre === $g ? 'topic-item-active' : '' }}">{{ $g }}</a>
        @endforeach
        @auth
        <p class="side-card-group">Your content</p>
        <a href="{{ route('forum', ['filter' => 'mine']) }}" class="topic-item {{ $filter === 'mine' ? 'topic-item-active' : '' }}">My Posts</a>
        @endauth
    </div>
    <div class="forum-container">
        <div class="content-row" style="align-items: center; margin-bottom: 1rem;">
            <h2 style="margin: 0;">Forums</h2>
            <a href="{{ route('create') }}" style="text-decoration: none; color: #8c8c8c;">+ Create post</a>
        </div>

        <div id="posts-list">
        @forelse ($posts as $post)
        <div class="forum-post-item">
            <a href="{{ route('post.show', $post) }}" class="forum-post-link">
                <div class="forum-post">
                    <div class="forum-post-header">
                        <span class="forum-post-title">{{ $post->title }}</span>
                        <span class="forum-post-author">by {{ $post->user->name }}</span>
                        <span class="forum-post-genre">{{ $post->genre }}</span>
                    </div>
                    <p class="forum-post-desc">{{ $post->description }}</p>
                </div>
            </a>
            <div class="forum-post-actions">
                <form class="vote-form" method="POST" action="{{ route('post.vote', $post) }}" data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="hidden" name="vote" value="1">
                    <button @guest type="button" onclick="window.location='{{ route('account') }}'" @else type="submit" @endguest class="vote-btn {{ $post->userVote() === 1 ? 'vote-btn-active' : '' }}" id="upvote-{{ $post->id }}">&#128077; <span>{{ $post->upvotes }}</span></button>
                </form>
                <form class="vote-form" method="POST" action="{{ route('post.vote', $post) }}" data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="hidden" name="vote" value="-1">
                    <button @guest type="button" onclick="window.location='{{ route('account') }}'" @else type="submit" @endguest class="vote-btn {{ $post->userVote() === -1 ? 'vote-btn-active' : '' }}" id="downvote-{{ $post->id }}">&#128078; <span>{{ $post->downvotes }}</span></button>
                </form>
                <span class="forum-post-comment-count">&#128172; {{ $post->comments_count }}</span>
            </div>
        </div>
        @empty
            <p style="color: #888;">No posts yet. Be the first to create one!</p>
        @endforelse
        </div>
        <div id="posts-pagination"></div>
    </div>
    <div class="side-card">
        <h2 class="side-card-title">Trending</h2>
        @forelse ($trending as $t)
            <a href="{{ route('post.show', $t) }}" class="trending-item">
                <div class="trending-title">{{ $t->title }}</div>
                <span class="forum-post-genre">{{ $t->genre }}</span>
                <div class="trending-meta">
                    <span>{{ $t->user->name }}</span>
                    <span class="trending-votes">&#128077; {{ $t->upvotes }}</span>
                </div>
            </a>
        @empty
            <p style="color:#888;font-size:0.8rem;">No posts yet.</p>
        @endforelse
    </div>
</section>
<footer id="footer">
        <p>@Spitfire Shop</p>
        <p>This page is made and maintained by AdmiralKeso</p>
</footer>
    @vite(['resources/js/app.js'])
</body>
</html>