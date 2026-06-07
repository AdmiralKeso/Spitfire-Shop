<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account</title>
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
    
<div class="acc-card">

    @if (session('success'))
        <p class="acc-success">{{ session('success') }}</p>
    @endif

    @auth
        <div class="acc-profile">
            <div class="acc-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="acc-profile-name">{{ Auth::user()->name }}</div>
                <div class="acc-profile-email">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <hr class="acc-divider">

        <details class="acc-settings">
            <summary>Settings</summary>
            <form method="POST" action="{{ route('settings') }}" class="acc-settings-form">
                @csrf

                <label>Display name
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                </label>
                @error('name') <div class="acc-error">{{ $message }}</div> @enderror

                <label>Email
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required>
                </label>
                @error('email') <div class="acc-error">{{ $message }}</div> @enderror

                <label>New password <span class="acc-hint">(leave blank to keep current)</span>
                    <input type="password" name="password">
                </label>
                @error('password') <div class="acc-error">{{ $message }}</div> @enderror

                <label>Confirm new password
                    <input type="password" name="password_confirmation">
                </label>

                <button type="submit">Save changes</button>
            </form>
        </details>

        <hr class="acc-divider">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="acc-signout">Sign out</button>
        </form>
    @else
        <div class="acc-tabs">
            <button class="acc-tab-btn" id="tab-login" onclick="showTab('login')">Sign in</button>
            <button class="acc-tab-btn" id="tab-register" onclick="showTab('register')">Register</button>
        </div>

        <div class="acc-tab-content" id="form-login">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label>Email
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                @if ($errors->login->has('email'))
                    <div class="acc-error">{{ $errors->login->first('email') }}</div>
                @endif

                <label>Password
                    <input type="password" name="password" required>
                </label>

                <button type="submit">Sign in</button>
            </form>
        </div>

        <div class="acc-tab-content" id="form-register">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label>Name
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </label>
                @if ($errors->register->has('name'))
                    <div class="acc-error">{{ $errors->register->first('name') }}</div>
                @endif

                <label>Email
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                @if ($errors->register->has('email'))
                    <div class="acc-error">{{ $errors->register->first('email') }}</div>
                @endif

                <label>Password
                    <input type="password" name="password" required>
                </label>
                @if ($errors->register->has('password'))
                    <div class="acc-error">{{ $errors->register->first('password') }}</div>
                @endif

                <label>Confirm password
                    <input type="password" name="password_confirmation" required>
                </label>

                <button type="submit">Create account</button>
            </form>
        </div>

        <script>
            function showTab(name) {
                document.querySelectorAll('.acc-tab-btn, .acc-tab-content').forEach(el => el.classList.remove('active'));
                document.getElementById('tab-' + name).classList.add('active');
                document.getElementById('form-' + name).classList.add('active');
            }
            @if ($errors->login->any())
                showTab('login');
            @elseif ($errors->register->any())
                showTab('register');
            @else
                showTab('login');
            @endif
        </script>
    @endauth

</div>
</body>
</html>
