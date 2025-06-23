<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Peminjaman Buku') }}</title>

    <!-- Fonts & Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #2d3748;
            --light-bg: #f8f9fa;
            --border-color: #e2e8f0;
            --sidebar-width: 250px;
        }
        body {
            min-height: 100vh;
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--secondary) 0%, #1a202c 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }
        .sidebar a {
            color: #cbd5e0;
            padding: 0.875rem 1.5rem;
            text-decoration: none;
            display: flex;
            gap: 0.75rem;
            align-items: center;
            border-left: 3px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: var(--primary);
        }
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .top-navbar {
            background-color: white;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }
        .main-content {
            flex: 1;
            padding: 1.5rem;
            background-color: var(--light-bg);
        }
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .content-wrapper {
                margin-left: 0;
            }
            .sidebar.show {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
@if(request()->is('login') || request()->is('register'))
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <h1><i class="fas fa-book"></i> Perpustakaan</h1>
                <p class="text-muted">Administrasi Peminjaman Buku</p>
            </div>
            {{ $slot }}
        </div>
    </div>
@else
    <div class="sidebar">
        <div class="sidebar-header p-3">
            <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center gap-2">
                <i class="fas fa-book-open"></i><span>Perpustakaan</span>
            </a>
        </div>
        <div>
            @role('admin|librarian')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Kelola Pengguna
                </a>
                <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Buku
                </a>
                <a href="{{ route('lendings.index') }}" class="{{ request()->routeIs('lendings.*') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i> Peminjaman
                </a>
                <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tag"></i> Peran
                </a>
                <a href="{{ route('admin.user_role.index') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                    <i class="fas fa-key"></i> Hak Akses
                </a>
            @elserole('member')
                <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Buku
                </a>
                <a href="{{ route('lendings.my_books') }}" class="{{ request()->routeIs('lendings.my_books') ? 'active' : '' }}">
                    <i class="fas fa-book-reader"></i> Buku yang Saya Pinjam
                </a>

            @endrole
        </div>
        <div class="p-3 border-top">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-light w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                </button>
            </form>
        </div>
    </div>
    <div class="content-wrapper">
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center w-100">
                <button class="btn btn-sm d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="nav-user d-flex align-items-center gap-2">
                    <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name fw-bold">{{ Auth::user()->name ?? 'Guest' }}</div>
                        <div class="user-role text-muted small">{{ Auth::user()?->getRoleNames()?->implode(', ') }}</div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="main-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('show');
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>
