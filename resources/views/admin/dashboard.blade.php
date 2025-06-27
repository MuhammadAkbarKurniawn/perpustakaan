@extends('layouts.app')

@hasanyrole('admin|librarian')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">📊 Dashboard Admin</h2>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 mb-2">Total Pengguna</div>
            <div class="text-3xl font-semibold text-blue-600">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 mb-2">Total Buku</div>
            <div class="text-3xl font-semibold text-green-600">{{ $totalBooks }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 mb-2">Buku Dipinjam</div>
            <div class="text-3xl font-semibold text-yellow-500">{{ $borrowedBooks }}</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <div class="text-gray-500 mb-2">Buku Tersedia</div>
            <div class="text-3xl font-semibold text-cyan-600">{{ $availableBooks }}</div>
        </div>
    </div>

    <!-- Tabel Peminjaman Terbaru -->
    <div class="bg-white shadow rounded-lg">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h5 class="font-semibold text-lg">📖 Riwayat Peminjaman Terbaru</h5>
            <a href="{{ route('lendings.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Pengembalian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentLendings as $lending)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $lending->book->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lending->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($lending->borrowed_at)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($lending->due_at)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lending->returned_at)
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Dikembalikan</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">Tidak ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@endhasanyrole
