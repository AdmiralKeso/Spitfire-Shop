<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenSkies</title>
    @vite(['resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('{{ asset('images/background/background.jpg') }}');
            background-size: cover;
            color: rgb(255, 255, 255);
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

    <div class="banner">
        <button class="banner-btn banner-btn-prev" onclick="changeImage()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="banner-btn banner-btn-next" onclick="changeImage()">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        <img src="{{ asset('images/background/spitfire-bannermain.jpg') }}" alt="spitfire banner" id="image1">
        <img src="{{ asset('images/background/bundeswehr.jpg') }}" alt="bundeswehr banner" id="image2">
        <div class="banner-dots">
            <span class="banner-dot active" onclick="goToSlide(0)"></span>
            <span class="banner-dot" onclick="goToSlide(1)"></span>
        </div>
    </div>

    <div class="margin">
<div class="card-row">
    <div class="card-top">
        <img src="{{ asset('images/background/spitfire-img.jpg') }}" alt="spitfire" id="background-img" style="width: 100%;">
        <div class="overlay">
            <h2>Spitfire: The iconic fighter that turned the tide</h2>
            <p>The Supermarine Spitfire was more than just a fighter plane—it was a symbol of resilience during World War II.
                 With its speed, agility, and cutting-edge design, the Spitfire played a crucial role in the Battle of Britain.
                  As outnumbered RAF pilots took to the skies, the Spitfire’s performance helped hold off the German Luftwaffe,
                   turning the tide of the war and proving that air superiority could change history.</p>
            <a href="https://sv.wikipedia.org/wiki/Supermarine_Spitfire" target="_blank" class="link"><span style="color: yellow;">> </span>Read more about why the spitfire was the most iconic fighter</a>
        </div>
    </div>
    <div class="card-column">
        <div class="card-top">
        <img src="{{ asset('images/background/Spitfire-hangar.jpg') }}" alt="hangar" style="width: 100%; height: 100%;">
        <div class="overlay">
            <h2>Welcome to the history forum</h2>
            <p class="overlay-p-responsive">Join our history forum and dive into discussions about world history.</p>
            <a href="{{ route('forum') }}" class="link"><span style="color: yellow;">> </span>To the history forum</a>
        </div>
    </div>
        <div class="card-top">
        <img src="{{ asset('images/background/merch.jpg') }}" alt="merch" style="width: 100%;">
        <div class="overlay">
            <h2>Spitfire merch</h2>
            <p>Check out our exclusive spitfire merch and look like the most iconic fighter pilot yourself!</p>
            <a href="https://shop.iwm.org.uk/collections/spitfire-clothing?srsltid=AfmBOoo-qoiJBwa1YP_qm4jPLXe5HnED7MspYuSpKVtRNtLR2jFDrpOj" target="_blank" class="link"><span style="color: yellow;">> </span>Spitfire merch</a>
        </div>
    </div>
    </div>
</div>
</div>
    <footer id="footer">
        <p>@Spitfire Shop</p>
        <p>This page is made and maintained by AdmiralKeso</p>
    </footer>

    <script>
        let img1 = document.getElementById("image1");
        let img2 = document.getElementById("image2");
        let slide = 0;
        const dots = document.querySelectorAll('.banner-dot');

        function updateDots() {
            dots.forEach((d, i) => d.classList.toggle('active', i === slide));
        }

        function changeImage() {
            img1.style.left = '-100%';
            img2.style.left = '0%';

            setTimeout(() => {
                let temp = img1.src;
                img1.src = img2.src;
                img2.src = temp;

                img1.style.transition = 'none';
                img2.style.transition = 'none';
                img1.style.left = '0%';
                img2.style.left = '100%';

                setTimeout(() => {
                    img1.style.transition = '';
                    img2.style.transition = '';
                }, 50);

                slide = slide === 0 ? 1 : 0;
                updateDots();
            }, 500);
        }

        setInterval(changeImage, 15000);
    </script>
</body>
</html>