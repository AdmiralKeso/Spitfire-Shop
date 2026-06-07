<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post — Spitfire Shop</title>
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

    <div class="margin">
            <section id="create-section">
                <div class="content-row">
                    <h2>Edit post</h2>
                    <a href="{{ route('post.show', $post) }}">Go back</a>
                </div>

                <form id="edit-form" method="POST" action="{{ route('post.update', $post) }}">
                    @csrf
                    @method('PUT')

                    <div class="content-column" style="gap: 0.5rem;">
                        <input type="text" name="title" placeholder="Title" value="{{ old('title', $post->title) }}" required style="padding: 0.4rem;">
                        @error('title') <div style="color:red; font-size:0.8rem;">{{ $message }}</div> @enderror

                        <select name="genre" required style="padding: 0.4rem;">
                            <option value="" disabled>Select genre</option>
                            @foreach (['General History','European History','Asian History','North American History','South American History'] as $g)
                                <option value="{{ $g }}" {{ old('genre', $post->genre) === $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                        @error('genre') <div style="color:red; font-size:0.8rem;">{{ $message }}</div> @enderror

                        <textarea name="description" style="resize: none; padding: 0.4rem;" rows="2"
                            placeholder="Short description (max 300 characters)..." maxlength="300"
                            required>{{ old('description', $post->description) }}</textarea>
                        @error('description') <div style="color:red; font-size:0.8rem;">{{ $message }}</div> @enderror

                        <textarea name="content" style="resize: vertical; padding: 0.4rem;" rows="10"
                            placeholder="Post content..." required>{{ old('content', $post->content) }}</textarea>
                        @error('content') <div style="color:red; font-size:0.8rem;">{{ $message }}</div> @enderror

                        <input type="submit" value="Save changes" style="padding: 0.4rem 1rem; cursor: pointer; width: fit-content;">
                    </div>
                </form>
        </section>
    </div>
</body>
</html>
