@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4">
    <div class="bg-white shadow rounded-lg">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <h5 class="text-lg font-semibold text-gray-700"><i class="fas fa-book mr-2"></i>Manajemen Buku</h5>
            <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700">
                <i class="fas fa-plus mr-1"></i> Tambah Buku Baru
            </a>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 flex justify-between items-center">
                    <div><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
                    <button onclick="this.parentElement.remove()" class="text-green-800 hover:text-green-900">&times;</button>
                </div>
            @endif

            {{-- Search Bar --}}
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="bookSearch" class="w-full pl-10 pr-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300" placeholder="Cari buku berdasarkan judul, penulis, atau ISBN...">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>

            {{-- Table Buku --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sampul</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Judul</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Penulis</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ISBN</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                            <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Status</th>
                            <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Jumlah</th>
                            <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Tersedia</th>
                            <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($books as $book)
                        <tr>
                            <td class="px-4 py-2">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="w-16 h-20 object-cover rounded">
                                @else
                                    <div class="w-16 h-20 flex items-center justify-center bg-gray-100 border text-gray-400 rounded">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-2 font-semibold">{{ $book->title }}</td>
                            <td class="px-4 py-2">{{ $book->author }}</td>
                            <td class="px-4 py-2"><span class="bg-gray-200 px-2 py-1 rounded text-xs">{{ $book->isbn }}</span></td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($book->description, 100) }}</td>
                            <td class="px-4 py-2 text-center">{{ $book->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                            <td class="px-4 py-2 text-center">{{ $book->total_copies }}</td>
                            <td class="px-4 py-2 text-center">
                                @if($book->available_copies > 0)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 text-sm rounded">{{ $book->available_copies }}</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 text-sm rounded">0</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right space-x-1">
                                <button onclick="openModal('modalBook{{ $book->id }}')" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('books.edit', $book) }}" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus buku ini?')" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $books->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Detail Buku --}}
@foreach($books as $book)
<div id="modalBook{{ $book->id }}" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg w-full max-w-md mx-auto p-6 relative shadow-xl">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-lg"
            onclick="closeModal('modalBook{{ $book->id }}')">&times;</button>
        <div class="flex flex-col items-center text-center">
            @if ($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                    class="w-40 h-56 object-cover mb-4 rounded shadow">
            @else
                <div class="w-40 h-56 bg-gray-100 flex items-center justify-center rounded text-gray-400 text-5xl mb-4">
                    <i class="fas fa-book"></i>
                </div>
            @endif
            <h3 class="text-xl font-semibold mb-1">{{ $book->title }}</h3>
            <p class="text-sm text-gray-600 mb-1"><strong>Penulis:</strong> {{ $book->author }}</p>
            <p class="text-sm text-gray-600 mb-1"><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p class="text-sm text-gray-600 mb-1"><strong>Tahun:</strong> {{ $book->publication_year ?? '-' }}</p>
            <p class="text-sm text-gray-600 mb-2"><strong>Tersedia:</strong> {{ $book->available_copies }} / {{ $book->total_copies }}</p>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $book->description }}</p>
        </div>
    </div>
</div>
@endforeach

{{-- Script Modal --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Optional: Search function (bonus enhancement)
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('bookSearch');
        const rows = document.querySelectorAll('tbody tr');

        input.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    });
</script>
@endsection
