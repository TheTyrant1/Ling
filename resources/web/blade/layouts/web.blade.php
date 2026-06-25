<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ling</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/web/images/favicon/favicon.svg') }}">

    <meta name="description" content="Ling is a social platform to connect, share, and discover content that matters to you.">



    <meta property="og:site_name" content="Ling">

    <meta property="og:type" content="website">

    <meta property="og:url" content="{{ url('/') }}">

    <meta property="og:title" content="Ling - If you want this, ling yourself">

    <meta property="og:description" content="Ling is a social platform to connect, share, and discover content that matters to you.">

    <meta property="og:image" content="{{ asset('assets/web/images/open-graph/ling-banner.png') }}">

    <meta property="og:image:width" content="1200">

    <meta property="og:image:height" content="630">



    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="Ling - If you want this, ling yourself">

    <meta name="twitter:description" content="New social media platform for everyone">

    <meta name="twitter:image" content="{{ asset('assets/web/images/open-graph/ling-banner.png') }}">

    @vite(['resources/web/scss/app.scss', 'resources/web/js/app.js'])
</head>

<body data-cookie-consent="{{ auth()->guest() ? 'true' : 'false' }}">

<div class="loader">
    <div class="loader__spinner"></div>
</div>

<header class="header">
    <div class="header__container">
        <div class="header__inner">
            <div class="header__card-container">
                <a href="{{ route('post.index') }}" class="header__logo-wrapper">
                    <img class="logo" src="{{ asset('assets/web/images/logo/logo.svg') }}" alt="Ling">
                </a>

                @include('web::blade.includes.search')

                @auth()
                    <div class="user-profile">
                        <button class="user-profile__avatar-btn" id="avatarBtn">
                            <img src="{{ Storage::url(auth()->user()->profile_image) }}" alt="User image"
                                 class="user-profile__avatar">
                        </button>
                    </div>
                @endauth

                @guest
                    <div class="header__authentication-text-container">
                        <a href="{{ route('login') }}" class="header__login-btn">Login</a>
                        <a href="{{ route('register') }}" class="header__register-btn">Register</a>
                    </div>
                @endguest
            </div>

            @auth()
                <div class="user-profile__dropdown" id="dropdownMenu">
                    <ul class="user-profile__menu">
                        <li class="user-profile__item">
                            <a href="{{ route('user.show', auth()->id()) }}" class="user-profile__link">My profile</a>
                        </li>
                        <li class="user-profile__item">
                            <a href="{{ route('personal.profile.edit') }}" class="user-profile__link">Personal</a>
                        </li>
                        @if(auth()->user()->role_id === 1)
                            <li class="user-profile__item">
                                <a href="{{ route('admin.home.index') }}" class="user-profile__link">Admin</a>
                            </li>
                        @endif
                        <li class="user-profile__item">
                            <form action="{{ route('logout') }}" method="POST" class="user-profile__logout-form">
                                @csrf
                                <button type="submit" class="user-profile__link user-profile__link--logout">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</header>

@yield('content')

<footer class="footer">
    <div class="footer__container">
        <div class="footer__card">
            <a href="{{ route('post.index') }}" class="header__logo-wrapper">
                <img class="logo" src="{{ asset('assets/web/images/logo/logo.svg') }}" alt="Ling">
            </a>
            <p class="footer__text">
                &copy;
                @if(now()->format('Y') == 2026)
                    2026
                @else
                    2026-{{ now()->format('Y') }}
                @endif
                // All rights reserved.
                <br>If you want this, ling yourself.
            </p>
        </div>
    </div>
</footer>

<div class="modal-window" id="authRequiredModal" aria-hidden="true">
    <div class="modal-window__overlay" data-close-modal></div>
    <div class="modal-window__container">
        <div class="modal-window__content">
            <button class="modal-window__close" data-close-modal aria-label="Close modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-window__body">
                <div class="modal-window__icon">
                    <i class="fa-solid fa-lock"></i>
                </div>

                <h4 class="modal-window__title">Authentication Required</h4>

                <p class="modal-window__text">
                    Please log in or register to continue.
                </p>

                <div class="modal-window__actions">
                    <button type="button" class="modal-window__btn modal-window__btn--secondary" data-close-modal>
                        Cancel
                    </button>

                    <a href="{{ route('login') }}" class="modal-window__btn modal-window__btn--primary">
                        Log In
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
