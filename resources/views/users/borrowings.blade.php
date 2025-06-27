@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h3 class="text-2xl font-bold text-blue-700 mb-6">📚 Buku yang Dipinjam oleh {{ $user->name }}</h3>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Pengembalian</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pengembalian</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($user->lendingRecords as $lending)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $lending->book->title ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($lending->borrowed_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($lending->due_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @if ($lending->returned_at)
                                {{ \Carbon\Carbon::parse($lending->returned_at)->format('d M Y') }}
                            @else
                                <span class="text-gray-400 italic">Belum dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($lending->returned_at)
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Dikembalikan</span>
                            @elseif (now()->gt($lending->due_at))
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Terlambat</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-500">
                            <i class="fas fa-book-open fa-lg mb-2"></i><br>
                            Tidak ada data peminjaman untuk pengguna ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 text-sm rounded hover:bg-gray-300">
            ← Kembali ke Daftar Pengguna
        </a>
    </div>
</div>
@endsection
