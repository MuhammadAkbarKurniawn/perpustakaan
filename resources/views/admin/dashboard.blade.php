@extends('layouts.app')

@hasanyrole('admin|librarian')
@section('content')
<div class="container py-5">
    <h2 class="mb-5 fw-bold text-primary">📊 Dashboard Admin</h2>

    <!-- Kartu Statistik -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Pengguna</div>
                    <div class="display-6 fw-semibold text-primary">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Total Buku</div>
                    <div class="display-6 fw-semibold text-success">{{ $totalBooks }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Buku Dipinjam</div>
                    <div class="display-6 fw-semibold text-warning">{{ $borrowedBooks }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 text-center h-100">
                <div class="card-body">
                    <div class="text-muted mb-2">Buku Tersedia</div>
                    <div class="display-6 fw-semibold text-info">{{ $availableBooks }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Peminjaman Terbaru -->
    <div class="card border-0 shadow rounded-3">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">📖 Riwayat Peminjaman Terbaru</h5>
            <a href="{{ route('lendings.index') }}" class="btn btn-sm btn-outline-primary">
                Lihat Semua
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Buku</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Pengembalian</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLendings as $lending)
                        <tr>
                            <td class="fw-medium">{{ $lending->book->title }}</td>
                            <td>{{ $lending->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($lending->borrowed_at)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($lending->due_at)->format('d M Y') }}</td>
                            <td>
                                @if($lending->returned_at)
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-danger">Dipinjam</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@endhasanyrole
