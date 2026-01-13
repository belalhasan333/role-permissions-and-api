<nav class="sidebar sidebar-offcanvas fixed-sidebar" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('Backend/assets/images/logo-mini.jpg') }}" alt="logo" />
        </a>
        <a class="sidebar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <img src="{{ asset('Backend/assets/images/logo-mini.jpg') }}" alt="logo" />
        </a>
    </div>

    <ul class="nav flex-column">
        @auth
            <!-- User Profile -->
            <li class="nav-item profile">
                <div class="profile-desc">
                    <div class="profile-pic">
                        <div class="count-indicator">
                            <img class="img-xs rounded-circle"
                                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('Backend/assets/images/faces/face15.jpg') }}"
                                alt="profile">
                            <span class="count bg-success"></span>
                        </div>
                        <div class="profile-name">
                            <h5 class="mb-0 font-weight-normal text-white">{{ Auth::user()->name }}</h5>
                            <span class="text-white">{{ Auth::user()->role ?? 'Member' }}</span>
                        </div>
                    </div>

                    <a href="#" id="profile-dropdown" data-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list"
                        aria-labelledby="profile-dropdown">
                        <a href="{{ route('profile.index') }}" class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-account text-primary"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1 text-small">My Profile</p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item preview-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-logout text-danger"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject ellipsis mb-1 text-small">Log Out</p>
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>

            <!-- Navigation Header -->
            <li class="nav-item nav-category">
                <span class="nav-link">Navigation</span>
            </li>

            <!-- Dashboard -->
            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <!-- Users (Web route) -->
            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-account-multiple"></i></span>
                    <span class="menu-title">Manage Users</span>
                </a>
            </li>

            <!-- Roles & Permissions -->

            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs(['roles.*', 'permissions.*']) ? 'active' : '' }}"
                    href="{{ route('roles.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-shield-account"></i></span>
                    <span class="menu-title">Manage Roles & Permissions</span>
                </a>
            </li>

            <!-- Categories (Web route) -->
            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                    href="{{ route('categories.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-folder-multiple"></i></span>
                    <span class="menu-title">Manage Categories</span>
                </a>
            </li>

            <!-- Products (Web route) -->
            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                    href="{{ route('products.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-book-open-variant"></i></span>
                    <span class="menu-title">Manage Products</span>
                </a>
            </li>

            <!-- Orders (No route implemented yet) -->
            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="#">
                    <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
                    <span class="menu-title">Orders</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item menu-items">
                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                    href="{{ route('profile.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-account-circle"></i></span>
                    <span class="menu-title">Profile</span>
                </a>
            </li>

            <!-- Settings -->

            <li class="nav-item menu-items">
                <a class="nav-link" data-toggle="collapse" href="#settingsMenu"
                    aria-expanded="{{ request()->routeIs(['settings.*', 'smtp.*']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="mdi mdi-cog"></i></span>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse {{ request()->routeIs(['settings.*', 'smtp.*']) ? 'show' : '' }}" id="settingsMenu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                                href="#">General Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('smtp.*') ? 'active' : '' }}" href="#">SMTP
                                Settings</a>
                        </li>
                    </ul>
                </div>
            </li>
        @else
            <li class="nav-item">
                <span class="nav-link text-center">Please login to see menu</span>
            </li>
        @endauth
    </ul>
</nav>
