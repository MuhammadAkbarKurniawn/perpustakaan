@extends('layouts.app')

@role('member')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">📚 Buku yang Saya Pinjam</h2>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Pengembalian</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($lendings as $lend)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $lend->book->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $lend->borrowed_at ? \Carbon\Carbon::parse($lend->borrowed_at)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $lend->due_at ? \Carbon\Carbon::parse($lend->due_at)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($lend->returned_at)
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Dikembalikan</span>
                            @elseif($lend->due_at && now()->gt($lend->due_at))
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Terlambat</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Sedang Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500">
                            <i class="fas fa-book-open fa-2x mb-2"></i><br>
                            Anda belum meminjam buku apa pun.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@endrole
