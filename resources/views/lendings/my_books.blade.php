@extends('layouts.app')

@role('member')
@section('content')
<div class="container">
    <h2>📚 Buku yang Saya Pinjam</h2>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lendings as $lend)
                <tr>
                    <td>{{ $lend->book->title }}</td>
                    <td>{{ $lend->borrowed_at ? \Carbon\Carbon::parse($lend->borrowed_at)->format('d M Y') : '-' }}</td>
                    <td>{{ $lend->due_at ? \Carbon\Carbon::parse($lend->due_at)->format('d M Y') : '-' }}</td>
                    <td>
                        @if($lend->returned_at)
                            <span class="badge bg-success">Dikembalikan</span>
                        @elseif($lend->due_at && now()->gt($lend->due_at))
                            <span class="badge bg-danger">Terlambat</span>
                        @else
                            <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Anda belum meminjam buku apa pun.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@endrole
