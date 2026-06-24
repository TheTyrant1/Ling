<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ling</title>

    @vite(['resources/web/scss/app.scss', 'resources/web/js/app.js'])
</head>

<body>

<div class="loader">
    <div class="loader__spinner"></div>
</div>

<header class="header">
    <div class="header__container">
        <div class="header__inner">
            <div class="header__card-container">
                <a href="{{ route('post.index') }}">
                    <img src="{{ asset('assets/web/images/logo/logo.svg') }}" alt="Ling">
                </a>

                @include('web::blade.includes.search')

                @auth()
                    <div class="user-profile">
                        <button class="user-profile__avatar-btn" id="avatarBtn">
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="User image"
                                 class="user-profile__avatar">
                        </button>
                    </div>
                @endauth

                @guest()
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
                        <li class="user-profile__item">
                            <a href="{{ route('admin.home.index') }}" class="user-profile__link">Admin</a>
                        </li>
                        <li class="user-profile__item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
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
            <a href="{{ route('post.index') }}">
                <img src="{{ asset('assets/web/images/logo/logo.svg') }}" alt="Ling">
            </a>
            <p class="footer__text">
                {{ now()->format('Y') }} // All rights reserved.
                <br>If you want this, ling yourself.
            </p>
        </div>
    </div>
</footer>

<div class="modal fade" id="authRequiredModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
             style="border-radius:15px;border:none;box-shadow:0 10px 30px rgba(0,0,0,0.1);">

            <div class="modal-body text-center p-5">

                <i class="fa-solid fa-lock mb-3"
                   style="font-size:40px;color:#4e4e4e;"></i>

                <h4 class="fw-bold mb-2">Authentication Required</h4>

                <p class="text-muted mb-4">
                    Please log in or register to continue.
                </p>

                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-light border" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <a href="{{ route('login') }}" class="btn btn-dark">
                        Log In
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
