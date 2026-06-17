<aside class="app-sidebar bg-body-secondary shadow d-flex flex-column" data-bs-theme="dark" style="min-height: 100vh;">
    <div class="sidebar-brand">
        <a class="navbar-brand" href="{{ route('personal.profile.edit') }}">
            <img src="{{ asset('assets/personal/images/logo/logo.svg') }}" alt="WebLing">
        </a>
    </div>

    <div class="sidebar-wrapper flex-grow-1 d-flex flex-column">
        <nav class="mt-2 d-flex flex-column flex-grow-1">
            <ul
                class="nav sidebar-menu d-flex flex-column flex-grow-1"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation"
            >
                <li class="nav-item">
                    <a href="{{ route('personal.profile.edit') }}" class="nav-link">
                        <i class="fa-solid fa-circle-user nav-icon"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('personal.notification.index') }}" class="nav-link">
                        <i class="fa-solid fa-bell nav-icon"></i>
                        <p>Notifications
                            @if($unreadCount > 0)
                                <span class="ms-1 text-success fw-bold">
                                    {{ Number::abbreviate($unreadCount) }}
                                </span>
                            @endif
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('personal.following.index') }}" class="nav-link">
                        <i class="fa-solid fa-user-plus nav-icon"></i>
                        <p>Following</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('personal.history.index') }}" class="nav-link">
                        <i class="fa-solid fa-clock-rotate-left nav-icon"></i>
                        <p>History</p>
                    </a>
                </li>
                @if(auth()->user()->status_id === 1)
                    <li class="nav-item">
                        <a href="{{ route('personal.post.index') }}" class="nav-link">
                            <i class="fa-solid fa-inbox nav-icon"></i>
                            <p>Posts</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('personal.appeal.index') }}" class="nav-link">
                        <i class="fa-solid fa-gavel nav-icon"></i>
                        <p>Appeals</p>
                    </a>
                </li>

                <!-- Тепер mt-auto відпрацює ідеально, бо батьківський <ul> є flex-column з повною висотою -->
                @if(auth()->user()->status_id === 1)
                    <li class="nav-item mt-auto mb-2">
                        <a href="{{ route('personal.trash.post.index') }}" class="nav-link">
                            <i class="fa-solid fa-trash nav-icon"></i>
                            <p>Trash</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
