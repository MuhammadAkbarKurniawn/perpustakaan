@extends('layouts.app')

@hasanyrole('admin|librarian')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h5 class="text-lg font-semibold"><i class="fas fa-handshake mr-2"></i>Manajemen Peminjaman</h5>
            <a href="{{ route('lendings.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-1"></i> Pinjam Buku
            </a>
        </div>

        <div class="px-6 py-4">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 text-sm rounded">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <div class="flex items-center border rounded-md overflow-hidden">
                    <span class="px-3 text-gray-500 bg-white border-r">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="lendingSearch" class="flex-1 py-2 px-3 text-sm focus:outline-none" placeholder="Cari berdasarkan judul buku atau nama peminjam...">
                </div>
                <div class="flex justify-end gap-2">
                    <button class="filter-btn px-4 py-2 text-sm border rounded-md text-gray-700 hover:bg-gray-100 active" data-filter="all">Semua</button>
                    <button class="filter-btn px-4 py-2 text-sm border rounded-md text-gray-700 hover:bg-gray-100" data-filter="borrowed">Sedang Dipinjam</button>
                    <button class="filter-btn px-4 py-2 text-sm border rounded-md text-gray-700 hover:bg-gray-100" data-filter="returned">Dikembalikan</button>
                    <button class="filter-btn px-4 py-2 text-sm border rounded-md text-gray-700 hover:bg-gray-100" data-filter="overdue">Terlambat</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 bg-gray-100 uppercase">
                        <tr>
                            <th class="px-4 py-3">Detail Buku</th>
                            <th class="px-4 py-3">Peminjam</th>
                            <th class="px-4 py-3">Periode Peminjaman</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($lendings as $lend)
                        @php
                            $isOverdue = !$lend->returned_at && \Carbon\Carbon::parse($lend->due_at)->isPast();
                            $status = $lend->returned_at ? 'returned' : ($isOverdue ? 'overdue' : 'borrowed');
                            $daysOverdue = $isOverdue ? \Carbon\Carbon::parse($lend->due_at)->diffInDays(now()) : 0;
                        @endphp
                        <tr data-status="{{ $status }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if($lend->book->cover_image)
                                        <img src="{{ asset('storage/' . $lend->book->cover_image) }}" alt="Cover" class="w-10 h-14 object-cover rounded mr-3">
                                    @else
                                        <div class="w-10 h-14 bg-gray-100 flex items-center justify-center rounded text-gray-400 mr-3">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold">{{ $lend->book->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $lend->book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center mr-2 text-sm font-bold">
                                        {{ substr($lend->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        {{ $lend->user->name }}
                                        <div class="text-xs text-gray-500">{{ $lend->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm space-y-1">
                                <div>
                                    <span class="text-gray-500">Dipinjam:</span>
                                    <span>{{ $lend->created_at->format('d M Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Jatuh Tempo:</span>
                                    <span class="{{ $isOverdue && !$lend->returned_at ? 'text-red-600 font-semibold' : '' }}">
                                        {{ \Carbon\Carbon::parse($lend->due_at)->format('d M Y') }}
                                    </span>
                                </div>
                                @if($lend->returned_at)
                                <div>
                                    <span class="text-gray-500">Dikembalikan:</span>
                                    <span>{{ \Carbon\Carbon::parse($lend->returned_at)->format('d M Y') }}</span>
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($lend->returned_at)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Dikembalikan</span>
                                @elseif($isOverdue)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Terlambat ({{ $daysOverdue }}h)</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">Dipinjam</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if(!$lend->returned_at)
                                    <form method="POST" action="{{ route('lendings.return', $lend->id) }}" class="inline">
                                        @csrf
                                        <button class="text-green-600 hover:text-green-800 text-sm mr-2">
                                            <i class="fas fa-undo"></i> Kembalikan
                                        </button>
                                    </form>
                                    <!-- Tombol Perpanjang -->
                                    <button class="text-yellow-500 hover:text-yellow-700 text-sm" onclick="document.getElementById('extendModal{{ $lend->id }}').classList.remove('hidden')">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>

                                    <!-- Modal Perpanjang -->
                                    <div id="extendModal{{ $lend->id }}" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
                                        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                                            <h2 class="text-lg font-semibold mb-4">Perpanjang Jatuh Tempo</h2>
                                            <form action="{{ route('lendings.extend', $lend->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-4">
                                                    <label for="due_at" class="block text-sm font-medium text-gray-700">Tanggal Baru</label>
                                                    <input type="date" name="due_at" min="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($lend->due_at)->format('Y-m-d') }}" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                                                </div>
                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button type="button" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm" onclick="document.getElementById('extendModal{{ $lend->id }}').classList.add('hidden')">Batal</button>
                                                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-green-600 text-sm"><i class="fas fa-check mr-1"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-6 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-handshake fa-2x mb-2"></i>
                                    <h5 class="font-semibold">Tidak ada data peminjaman</h5>
                                    <p class="text-sm">Belum terdapat data peminjaman buku di sistem.</p>
                                    <a href="{{ route('lendings.create') }}" class="mt-2 px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                        <i class="fas fa-plus mr-1"></i> Tambah Peminjaman Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-6 text-sm text-gray-600">
                <div>
                    Menampilkan <span class="font-medium" id="visibleCount">{{ count($lendings) }}</span> dari {{ $lendings->total() }} data
                </div>
                <div class="mt-4 md:mt-0">
                    {{ $lendings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('lendingSearch');
    const rows = document.querySelectorAll('tbody tr[data-status]');
    const filterButtons = document.querySelectorAll('.filter-btn');
    let activeFilter = 'all';

    function filterRows() {
        const keyword = searchInput.value.toLowerCase();

        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const status = row.dataset.status;

            const matchKeyword = text.includes(keyword);
            const matchStatus = (activeFilter === 'all') || (status === activeFilter);

            if (matchKeyword && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update jumlah tampilan
        document.getElementById('visibleCount').textContent = visibleCount;
    }

    searchInput.addEventListener('input', filterRows);

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Set semua tombol nonaktif dulu
            filterButtons.forEach(b => b.classList.remove('bg-blue-600', 'text-white', 'active'));
            // Aktifkan tombol yang diklik
            btn.classList.add('bg-blue-600', 'text-white', 'active');
            activeFilter = btn.dataset.filter;
            filterRows();
        });
    });
});
</script>


@endsection
@endhasanyrole
