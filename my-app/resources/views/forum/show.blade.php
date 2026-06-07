<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} — Spitfire Shop</title>
    @vite(['resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            color: rgb(0, 0, 0);
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
            <a class="item" href="{{ route('home') }}">Home</a>
            <a class="item">Gallery</a>
            <a class="item" href="https://shop.iwm.org.uk/collections/spitfire-clothing?srsltid=AfmBOoo-qoiJBwa1YP_qm4jPLXe5HnED7MspYuSpKVtRNtLR2jFDrpOj" target="_blank">Merch</a>
            <a class="item" href="{{ route('forum') }}" style="text-decoration: underline;">Forum</a>
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

    <div class="margin" style="padding: 2rem 0;">
        <a href="{{ route('forum') }}" style="font-size: 0.875rem; color: #666; text-decoration: none;">← Back to forum</a>

        <div class="forum-show-card">
            <div class="forum-show-meta">
                <span class="forum-post-genre">{{ $post->genre }}</span>
                <span style="color: #888; font-size: 0.85rem;">by {{ $post->user->name }}</span>
                <span style="color: #aaa; font-size: 0.8rem;">{{ $post->created_at->format('d M Y') }}</span>
                @auth @if(Auth::id() === $post->user_id)
                    <a href="{{ route('post.edit', $post) }}" style="margin-left:auto; font-size:0.8rem;">Edit</a>
                    <form method="POST" action="{{ route('post.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;color:red;font-size:0.8rem;cursor:pointer;padding:0;">Delete</button>
                    </form>
                @endif @endauth
            </div>

            <h1 class="forum-show-title">{{ $post->title }}</h1>
            <p class="forum-show-desc">{{ $post->description }}</p>

            <hr style="margin: 1.5rem 0; border-color: #d4c5a9;">

            <div class="forum-show-content">{{ $post->content }}</div>
        </div>
        <div class="forum-vote-row">
                <form class="vote-form" method="POST" action="{{ route('post.vote', $post) }}" data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="hidden" name="vote" value="1">
                    <button @guest type="button" onclick="window.location='{{ route('account') }}'" @else type="submit" @endguest class="vote-btn {{ $post->userVote() === 1 ? 'vote-btn-active' : '' }}" id="upvote-{{ $post->id }}">
                        &#128077; <span>{{ $post->upvotes }}</span>
                    </button>
                </form>
                <form class="vote-form" method="POST" action="{{ route('post.vote', $post) }}" data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="hidden" name="vote" value="-1">
                    <button @guest type="button" onclick="window.location='{{ route('account') }}'" @else type="submit" @endguest class="vote-btn {{ $post->userVote() === -1 ? 'vote-btn-active' : '' }}" id="downvote-{{ $post->id }}">
                        &#128078; <span>{{ $post->downvotes }}</span>
                        </button>
                </form>
        </div>

        <div class="forum-show-card" style="margin-top: 1.5rem;">
            <h3>Comments ({{ $comments->count() }})</h3>

            @auth
                <form method="POST" action="{{ route('post.comment', $post) }}" style="margin-bottom: 1.5rem;">
                    @csrf
                    <textarea name="body" maxlength="300" placeholder="Write a comment…" required
                        style="width: 100%; padding: 0.6rem; border: 1px solid #c8b89a; border-radius: 4px; resize: vertical; min-height: 80px; font-family: inherit;"></textarea>
                    @error('body') <p style="color: red; font-size: 0.85rem;">{{ $message }}</p> @enderror
                    <button type="submit" style="margin-top: 0.5rem; padding: 0.4rem 1rem; background: #7c7c00; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Post comment
                    </button>
                </form>
            @else
                <p style="color: #888; margin-bottom: 1.5rem;"><a href="{{ route('account') }}">Sign in</a> to leave a comment.</p>
            @endauth

            @forelse ($comments as $comment)
                <div style="border-top: 1px solid #e8dcc8; padding: 0.75rem 0;">
                    <div style="font-size: 0.8rem; color: #888; margin-bottom: 0.3rem;">
                        <strong>{{ $comment->user->name }}</strong> · {{ $comment->created_at->diffForHumans() }}
                    </div>
                    <p style="margin: 0;">{{ $comment->body }}</p>
                </div>
            @empty
                <p style="color: #888;">No comments yet.</p>
            @endforelse
        </div>
    </div>

    <footer id="footer">
        <p>@Spitfire Shop</p>
        <p>This page is made and maintained by AdmiralKeso</p>
    </footer> 
</body>
</html>
