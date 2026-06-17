<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ling</title>

    @vite(['resources/web/scss/app.scss', 'resources/web/js/app.js'])
</head>

<div class="loader">
    <div class="loader__spinner"></div>
</div>

<body>
<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">

            <a href="{{ route('post.index') }}">
                <img src="{{ asset('assets/web/images/logo/logo.svg') }}" alt="Ling">
            </a>

            @include('web::blade.includes.search', [
                'class' => 'us-nav-centered',
                'style' => 'max-width: 500px;',
                'endpoint' => route('search.index'),
                'placeholder' => 'Search posts, users...'
            ])

            <div class="collapse navbar-collapse justify-content-end">

                <ul class="navbar-nav align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item">
                            <div class="profile-select">
                                <button type="button"
                                        class="profile-select__trigger"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        aria-label="User menu">

                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                                         alt="User image"
                                         class="profile-select__avatar">
                                </button>

                                <ul class="profile-select__menu">
                                    <li class="profile-select__item">
                                        <a href="{{ route('user.show', auth()->user()->id) }}"
                                           class="profile-select__link">Profile</a>
                                    </li>

                                    <li class="profile-select__item">
                                        <a href="{{ route('personal.profile.edit') }}"
                                           class="profile-select__link">Personal</a>
                                    </li>

                                    @if(auth()->user()->role_id == 1)
                                        <li class="profile-select__item">
                                            <a href="{{ route('admin.home.index') }}"
                                               class="profile-select__link">Admin</a>
                                        </li>
                                    @endif

                                    <li class="profile-select__divider" role="separator"></li>

                                    <li class="profile-select__item">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                    class="profile-select__link profile-select__link--danger">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endauth
                </ul>

            </div>
        </nav>
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
