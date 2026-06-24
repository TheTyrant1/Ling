<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ling</title>

    <link rel="icon" id="app-favicon" href="{{ asset('assets/admin/images/favicon/favicon-light.svg') }}" type="image/svg+xml">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="color-scheme" content="light dark"/>
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)"/>
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)"/>

    <script>
        const storedTheme = localStorage.getItem('theme');

        if (storedTheme) {
            document.documentElement.setAttribute('data-bs-theme', storedTheme);
        }
    </script>

    @vite(['resources/admin/scss/app.scss', 'resources/admin/js/app.js'])
</head>

<body class="layout-fixed fixed-header sidebar-expand-lg bg-body-tertiary">

<div class="app-loader">
    <div class="app-loader__spinner"></div>
</div>

<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item text-muted">
                    <a class="burger-btn" data-toggle="sidebar" href="#" role="button">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
            </ul>

            @include('admin::blade.includes.search',
                    [
                        'class' => 'search--nav-centered',
                        'endpoint' => route('admin.search.index'),
                        'placeholder' => 'Search posts, users...'
                    ])

            <ul class="navbar-nav d-flex justify-content-end align-items-center gap-2">
                <li class="nav-item dropdown">
                    <button
                        class="btn btn-link nav-link dropdown-toggle app-header__btn app-header__btn--theme"
                        id="bd-theme"
                        type="button"
                        data-bs-toggle="dropdown"
                        data-bs-display="static"
                        aria-expanded="false"
                    >
                        <span class="theme-icon-active">
                            <i class="fa-solid fa-circle-half-stroke"></i>
                        </span>

                        <span class="d-lg-none" id="bd-theme-text"></span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme">
                        <li>
                            <button
                                type="button"
                                class="dropdown-item d-flex align-items-center active"
                                data-bs-theme-value="light"
                                aria-pressed="false"
                            >
                                <i class="fa-solid fa-sun me-2 fa-fw"></i>
                                Light
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="dark"
                                aria-pressed="false"
                            >
                                <i class="fa-solid fa-moon me-2 fa-fw"></i>
                                Dark
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                class="dropdown-item d-flex align-items-center"
                                data-bs-theme-value="auto"
                                aria-pressed="true"
                            >
                                <i class="fa-solid fa-circle-half-stroke me-2 fa-fw"></i>
                                Auto
                                <i class="fa-solid fa-check ms-auto d-none"></i>
                            </button>
                        </li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center app-header__avatar-link" href="#" id="userMenuButton"
                       role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img
                            src="{{ asset('storage/' . auth()->user()->profile_image) }}"
                            alt="User image"
                            class="app-header__avatar-img">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                        <li><a class="dropdown-item" href="{{ route('post.index') }}">Back to Ling</a></li>
                        <li><a class="dropdown-item" href="{{ route('personal.profile.edit') }}">Personal</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    @include('admin::blade.includes.sidebar')

    @yield('content')

</div>
</body>
</html>
