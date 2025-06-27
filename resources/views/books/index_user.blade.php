@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-6">
    <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
        <i class="fas fa-book-reader mr-2"></i>Buku Tersedia untuk Dipinjam
    </h2>

    {{-- Search Bar --}}
    <div class="mb-8 max-w-xl mx-auto">
        <div class="relative">
            <input type="text" id="bookSearch" placeholder="Cari judul, penulis, atau ISBN..."
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search"></i>
            </span>
        </div>
    </div>

    {{-- Grid Buku --}}
    <div id="bookList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($books as $book)
            @if ($book->available_copies > 0)
            <div class="book-card-wrapper">
                <div
                    class="book-card bg-white shadow-md rounded-xl overflow-hidden flex flex-col transition-transform transform hover:scale-[1.03] hover:shadow-lg duration-200 h-full">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        @if ($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="object-cover w-full h-full">
                        @else
                            <i class="fas fa-book text-gray-300 text-5xl"></i>
                        @endif
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-semibold text-lg text-gray-800 mb-1 truncate">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">by {{ $book->author }}</p>
                        <p class="text-xs text-gray-500 mb-1">ISBN: {{ $book->isbn }}</p>
                        <p class="text-xs text-gray-500 mb-2">Tahun: {{ $book->publication_year ?? '-' }}</p>
                        <p class="text-sm text-gray-700 line-clamp-3 flex-grow">{{ Str::limit($book->description, 100) }}</p>

                        <div class="mt-3 flex items-center justify-between">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                Tersedia: {{ $book->available_copies }}
                            </span>
                            <button class="text-blue-600 text-sm hover:underline"
                                onclick="openModal('modalBook{{ $book->id }}')">Lihat Detail</button>
                        </div>
                    </div>
                </div>

                {{-- Modal --}}
                <div id="modalBook{{ $book->id }}"
                    class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center">
                    <div class="bg-white rounded-xl w-full max-w-2xl mx-auto p-6 relative shadow-2xl flex flex-col md:flex-row gap-6">
                        <button class="absolute top-3 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                            onclick="closeModal('modalBook{{ $book->id }}')">&times;</button>

                        {{-- Gambar Buku --}}
                        <div class="w-full md:w-1/2 flex-shrink-0">
                            @if ($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-full h-64 object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-full h-64 flex items-center justify-center bg-gray-100 border text-gray-300 rounded-lg">
                                    <i class="fas fa-book fa-4x"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Detail Buku --}}
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-1"><strong>Penulis:</strong> {{ $book->author }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Tahun:</strong> {{ $book->publication_year ?? '-' }}</p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Tersedia:</strong> {{ $book->available_copies }} / {{ $book->total_copies }}</p>
                            <div class="mt-4">
                                <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                                    {{ $book->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @empty
            <div class="col-span-12 text-center text-gray-500">
                <i class="fas fa-books fa-3x mb-2"></i>
                <p class="font-medium">Tidak ada buku tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $books->links('pagination::tailwind') }}
    </div>
</div>

{{-- Script --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('bookSearch');
        const wrappers = document.querySelectorAll('.book-card-wrapper');

        input.addEventListener('input', function () {
            const keyword = input.value.toLowerCase();
            wrappers.forEach(wrapper => {
                const card = wrapper.querySelector('.book-card');
                const text = card.innerText.toLowerCase();
                wrapper.style.display = text.includes(keyword) ? 'block' : 'none';
            });
        });
    });
</script>
@endsection
