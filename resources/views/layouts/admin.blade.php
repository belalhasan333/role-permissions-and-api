<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="admin-layout">

    <!-- ================= Sidebar ================= -->
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-logo">
            <span class="logo-text">NiceAdmin</span>
        </div>

        <ul class="sidebar-menu">
            <li><a href="#"><i class="fa fa-gauge"></i><span>Dashboard</span></a></li>
            <li><a href="{{ route('users.index') }}"><i class="fa fa-users"></i><span>Users</span></a></li>
            <li><a href="{{ route('roles.index') }}"><i class="fa fa-user-shield"></i><span>Roles</span></a></li>
            <li><a href="{{ route('products.index') }}"><i class="fa fa-box"></i><span>Products</span></a></li>
            <li><a href="{{ route('categories.index') }}"><i class="fa fa-layer-group"></i><span>Categories</span></a></li>
        </ul>
    </aside>

    <!-- ================= Main ================= -->
    <div class="main-content">

        <!-- ===== Top Navbar ===== -->
        <nav class="topbar">
            <button id="sidebarToggle" class="btn btn-light">
                <i class="fa fa-bars"></i>
            </button>

            <div class="topbar-right">

                {{-- Notifications --}}
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                @endphp

                <div class="dropdown">
                    <a class="icon-btn" data-bs-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="badge">{{ $unreadCount }}</span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-end p-2" style="width:300px">
                        <strong>Notifications</strong>
                        <hr>
                        @forelse(auth()->user()->notifications->take(5) as $n)
                            <a class="dropdown-item {{ $n->read_at ? '' : 'fw-bold' }}"
                               href="{{ route('notifications.read',$n->id) }}">
                                {{ $n->data['title'] ?? 'Notification' }}
                            </a>
                        @empty
                            <div class="text-muted">No notifications</div>
                        @endforelse
                    </div>
                </div>

                {{-- User --}}
                <div class="dropdown">
                    <a class="icon-btn" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                        <i class="fa fa-chevron-down"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
            </div>
        </nav>

        <!-- ===== Page Content ===== -->
        <main class="page-content">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>
