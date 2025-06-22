@extends('layouts.app')

@section('content')
@hasanyrole('admin|librarian|member')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-book me-2"></i>Manajemen Buku</h5>
            @role('admin|librarian')
            <a href="{{ route('books.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Buku Baru
            </a>
            @endrole
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="bookSearch" class="form-control border-start-0" placeholder="Cari buku berdasarkan judul, penulis, atau ISBN...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="booksTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px">Sampul</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>ISBN</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Tersedia</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>
                                <div class="book-cover">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-thumbnail">
                                    @else
                                        <div class="no-cover d-flex align-items-center justify-content-center text-muted">
                                            <i class="fas fa-book-open"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong>{{ $book->title }}</strong>
                                @if($book->publication_year)
                                    <div class="text-muted small">{{ $book->publication_year }}</div>
                                @endif
                            </td>
                            <td>{{ $book->author }}</td>
                            <td><span class="badge bg-light text-dark">{{ $book->isbn }}</span></td>
                            <td class="text-center">{{ $book->description }}</td>
                            <td class="text-center">{{ $book->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                            <td class="text-center">{{ $book->total_copies }}</td>
                            <td class="text-center">
                                @if($book->available_copies > 0)
                                    <span class="badge bg-success">{{ $book->available_copies }}</span>
                                @else
                                    <span class="badge bg-danger">0</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Semua role bisa lihat detail --}}
                                    <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#bookDetailsModal{{ $book->id }}" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @role('admin|librarian')
                                    <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endrole
                                </div>

                                <!-- Modal Detail Buku -->
                                <div class="modal fade" id="bookDetailsModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $book->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                                        @if($book->cover_image)
                                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid rounded">
                                                        @else
                                                            <div class="no-cover large d-flex align-items-center justify-content-center text-muted">
                                                                <i class="fas fa-book-open fa-3x"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <dl class="row mb-0">
                                                            <dt class="col-sm-4">Penulis</dt>
                                                            <dd class="col-sm-8">{{ $book->author }}</dd>

                                                            <dt class="col-sm-4">ISBN</dt>
                                                            <dd class="col-sm-8">{{ $book->isbn }}</dd>

                                                            <dt class="col-sm-4">Status</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $book->available_copies }} dari {{ $book->total_copies }} tersedia
                                                            </dd>

                                                            <dt class="col-12 mt-2">Deskripsi</dt>
                                                            <dd class="col-12"><p class="small text-muted">{{ $book->description }}</p></dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                @role('admin|librarian')
                                                <a href="{{ route('books.edit', $book) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                @endrole
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center text-muted">
                                    <i class="fas fa-books fa-3x mb-3"></i>
                                    <h5>Tidak ada buku ditemukan</h5>
                                    <p>Perpustakaan masih kosong. Tambahkan buku pertama sekarang.</p>
                                    @role('admin|librarian')
                                    <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Tambah Buku Pertama
                                    </a>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endhasanyrole
@endsection

{{-- Styles --}}
<style>
    .book-cover {
        width: 60px;
        height: 80px;
        overflow: hidden;
        border-radius: 4px;
    }
    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .no-cover {
        width: 60px;
        height: 80px;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 4px;
    }
    .no-cover.large {
        width: 100%;
        height: 200px;
    }
    .delete-btn:hover {
        background-color: #dc3545;
        color: white;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }
</style>

{{-- Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('bookSearch');
        const table = document.getElementById('booksTable');
        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            rows.forEach(row => {
                const title = row.cells[1].textContent.toLowerCase();
                const author = row.cells[2].textContent.toLowerCase();
                const isbn = row.cells[3].textContent.toLowerCase();

                if (title.includes(query) || author.includes(query) || isbn.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            const deleteBtn = form.querySelector('.delete-btn');
            deleteBtn.addEventListener('click', function (e) {
                e.preventDefault();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Buku ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm('Apakah kamu yakin ingin menghapus buku ini?')) {
                        form.submit();
                    }
                }
            });
        });

        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const closeButton = alert.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.click();
                }
            }, 5000);
        });
    });
</script>
