<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.home.index') }}">
            <img class="logo" src="{{ asset('assets/admin/images/logo/logo.svg') }}" alt="Ling">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation"
            >
                <li class="nav-item">
                    <a href="{{ route('admin.home.index') }}" class="nav-link">
                        <i class="fa-solid fa-house nav-icon"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.post.index') }}" class="nav-link">
                        <i class="fa-solid fa-inbox nav-icon"></i>
                        <p>Posts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tag.index') }}" class="nav-link">
                        <i class="fa-solid fa-hashtag nav-icon"></i>
                        <p>Tags</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" class="nav-link">
                        <i class="fa-solid fa-users nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.comment.index') }}" class="nav-link">
                        <i class="fa-regular fa-comment nav-icon"></i>
                        <p>Comments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.appeal.index') }}" class="nav-link">
                        <i class="fa-solid fa-gavel nav-icon"></i>
                        <p>Appeals</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
