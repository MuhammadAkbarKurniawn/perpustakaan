<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileMenuOpen: false }" x-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Peminjaman Buku') }}</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine.js for mobile menu toggle -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

@if(request()->is('login') || request()->is('register'))
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-book mr-2 text-indigo-600"></i>Perpustakaan</h1>
                <p class="text-sm text-gray-500">Administrasi Peminjaman Buku</p>
            </div>
            {{ $slot }}
        </div>
    </div>
@else
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand + Menu (left) -->
                <div class="flex items-center">
                    <a href="#" class="text-indigo-600 font-bold text-lg flex items-center gap-2">
                        <i class="fas fa-book-open"></i> <span>Perpustakaan</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-4 items-center ml-10">
                    @role('admin|librarian')
                        <x-nav-link route="admin.dashboard" label="Dashboard" />
                        <x-nav-link route="users.index" label="Pengguna" />
                        <x-nav-link route="books.index" label="Buku" />
                        <x-nav-link route="lendings.index" label="Peminjaman" />
                    @elserole('member')
                        <x-nav-link route="books.index" label="Buku" />
                        <x-nav-link route="lendings.my_books" label="Buku Saya" />
                    @endrole
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- User Info + Logout -->
                <div class="hidden md:flex items-center ml-6">
                    <div class="text-right mr-4">
                        <div class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Guest' }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()?->getRoleNames()?->implode(', ') }}</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="flex items-center px-3 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div class="md:hidden" x-show="mobileMenuOpen" x-transition>
            <div class="px-4 pb-4 space-y-2 bg-white border-t border-gray-100">
                @role('admin|librarian')
                    <x-nav-mobile route="admin.dashboard" label="Dashboard" />
                    <x-nav-mobile route="users.index" label="Pengguna" />
                    <x-nav-mobile route="books.index" label="Buku" />
                    <x-nav-mobile route="lendings.index" label="Peminjaman" />
                @elserole('member')
                    <x-nav-mobile route="books.index" label="Buku" />
                    <x-nav-mobile route="lendings.my_books" label="Buku Saya" />
                @endrole

                <div class="border-t pt-2">
                    <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Guest' }}</div>
                    <div class="text-xs text-gray-500 mb-2">{{ Auth::user()?->getRoleNames()?->implode(', ') }}</div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="flex items-center px-3 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 w-full">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
@endif

@stack('scripts')
</body>
</html>
