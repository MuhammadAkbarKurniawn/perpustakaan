<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Peminjaman Buku') }}</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #e0e7ff;
            --secondary: #1e293b;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            min-height: 100vh;
        }
        
        /* Navigation */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: var(--card-bg);
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 50;
            transition: transform 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            font-size: 1.25rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .sidebar-menu a:hover, 
        .sidebar-menu a.active {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        
        .sidebar-menu a i {
            width: 24px;
            text-align: center;
        }
        
        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        
        /* Main Content */
        .content-wrapper {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .top-navbar {
            background: var(--card-bg);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 40;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 500;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: var(--text-light);
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
            background-color: var(--light-bg);
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0;
            }
        }
        
        /* Auth Pages */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background-color: var(--light-bg);
        }
        
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-logo h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .auth-logo p {
            color: var(--text-light);
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
@if(request()->is('login') || request()->is('register'))
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <h1><i class="fas fa-book-open"></i> Perpustakaan</h1>
                <p>Administrasi Peminjaman Buku</p>
            </div>
            {{ $slot }}
        </div>
    </div>
@else
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-book-open"></i>
                <span>Perpustakaan</span>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Katalog Buku</span>
            </a>
            <a href="{{ route('lendings.my_books') }}" class="{{ request()->routeIs('lendings.my_books') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i>
                <span>Buku Saya</span>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 text-sm text-red-500 hover:text-red-700">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Top Navigation -->
        <nav class="top-navbar">
            <button class="lg:hidden" id="sidebarToggle">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
            
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <span class="user-role">Member</span>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <main class="main-content">
            <div class="container mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle sidebar on mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('show');
            });
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.sidebar');
            const isMobile = window.innerWidth < 1024;
            
            if (isMobile && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
                sidebar.classList.remove('show');
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>