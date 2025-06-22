@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Buku yang Dipinjam oleh {{ $user->name }}</h3>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Pengembalian</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($user->lendingRecords as $lending)
                <tr>
                    <td>{{ $lending->book->title ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($lending->borrowed_at)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($lending->due_at)->format('d M Y') }}</td>
                    <td>
                        @if ($lending->returned_at)
                            {{ \Carbon\Carbon::parse($lending->returned_at)->format('d M Y') }}
                        @else
                            <span class="text-muted">Belum dikembalikan</span>
                        @endif
                    </td>
                    <td>
                        @if ($lending->returned_at)
                            <span class="badge bg-success">Dikembalikan</span>
                        @elseif (now()->gt($lending->due_at))
                            <span class="badge bg-danger">Terlambat</span>
                        @else
                            <span class="badge bg-warning">Dipinjam</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data peminjaman untuk pengguna ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">← Kembali ke Daftar Pengguna</a>
</div>
@endsection
