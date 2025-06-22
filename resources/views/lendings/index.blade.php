@extends('layouts.app')
@hasanyrole('admin|librarian')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-handshake me-2"></i>Manajemen Peminjaman</h5>
            <a href="{{ route('lendings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Pinjam Buku
            </a>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="lendingSearch" class="form-control border-start-0" placeholder="Cari berdasarkan judul buku atau nama peminjam...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-md-end">
                        <button class="btn btn-outline-secondary filter-btn active" data-filter="all">Semua</button>
                        <button class="btn btn-outline-secondary filter-btn" data-filter="borrowed">Sedang Dipinjam</button>
                        <button class="btn btn-outline-secondary filter-btn" data-filter="returned">Dikembalikan</button>
                        <button class="btn btn-outline-secondary filter-btn" data-filter="overdue">Terlambat</button>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="lendingsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Detail Buku</th>
                            <th>Peminjam</th>
                            <th>Periode Peminjaman</th>
                            <th class="text-center" style="width: 120px">Status</th>
                            <th class="text-end" style="width: 180px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($lendings as $lend)
                        @php
                            $isOverdue = !$lend->returned_at && \Carbon\Carbon::parse($lend->due_at)->isPast();
                            $status = $lend->returned_at ? 'returned' : ($isOverdue ? 'overdue' : 'borrowed');
                            $daysOverdue = $isOverdue ? \Carbon\Carbon::parse($lend->due_at)->diffInDays(now()) : 0;
                        @endphp
                        <tr data-status="{{ $status }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($lend->book->cover_image)
                                        <img src="{{ asset('storage/' . $lend->book->cover_image) }}" alt="Cover" class="me-3 book-cover">
                                    @else
                                        <div class="no-cover me-3 d-flex align-items-center justify-content-center text-muted">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $lend->book->title }}</strong>
                                        <div class="text-muted small">{{ $lend->book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-2">{{ substr($lend->user->name, 0, 1) }}</div>
                                    <div>
                                        {{ $lend->user->name }}
                                        @if($lend->user->email)
                                            <div class="text-muted small">{{ $lend->user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="lending-dates">
                                    <div>
                                        <span class="text-muted">Dipinjam:</span> 
                                        <span class="ms-1">{{ $lend->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-muted">Jatuh Tempo:</span> 
                                        <span class="ms-1 {{ $isOverdue && !$lend->returned_at ? 'text-danger fw-bold' : '' }}">
                                            {{ \Carbon\Carbon::parse($lend->due_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                    @if($lend->returned_at)
                                    <div>
                                        <span class="text-muted">Dikembalikan:</span> 
                                        <span class="ms-1">{{ \Carbon\Carbon::parse($lend->returned_at)->format('d M Y') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if($lend->returned_at)
                                    <span class="badge bg-success">Dikembalikan</span>
                                @elseif($isOverdue)
                                    <span class="badge bg-danger">Terlambat ({{ $daysOverdue }}h)</span>
                                @else
                                    <span class="badge bg-warning">Dipinjam</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if(!$lend->returned_at)
                                    <form method="POST" action="{{ route('lendings.return', $lend->id) }}" class="d-inline">
                                         @csrf
                                        <button class="btn btn-sm btn-outline-success return-btn">
                                            <i class="fas fa-undo me-1"></i> Kembalikan
                                        </button>
                                    </form>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#extendModal{{ $lend->id }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                @else
                                    <span class="text-success"><i class="fas fa-check me-1"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        
                        <!-- Modal Perpanjang -->
                        <div class="modal fade" id="extendModal{{ $lend->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Perpanjang Jatuh Tempo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <form action="{{ route('lendings.index', $lend->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="due_at" class="form-label">Tanggal Baru</label>
                                                <input type="date" class="form-control" id="due_at" name="due_at" 
                                                       value="{{ \Carbon\Carbon::parse($lend->due_at)->format('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center text-muted">
                                    <i class="fas fa-handshake fa-3x mb-3"></i>
                                    <h5>Tidak ada data peminjaman</h5>
                                    <p>Belum terdapat data peminjaman buku di sistem.</p>
                                    <a href="{{ route('lendings.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Tambah Peminjaman Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan <span class="fw-semibold" id="visibleCount">{{ count($lendings) }}</span> dari {{ $lendings->total() }} data
                </div>
                <div class="pagination-container">
                    @if ($lendings->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm m-0">
                                {{-- Sebelumnya --}}
                                @if ($lendings->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $lendings->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                @endif

                                {{-- Halaman --}}
                                @foreach ($lendings->getUrlRange(max($lendings->currentPage() - 2, 1), 
                                                          min($lendings->currentPage() + 2, $lendings->lastPage())) as $page => $url)
                                    @if ($page == $lendings->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Selanjutnya --}}
                                @if ($lendings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $lendings->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


<style>
    .book-cover {
        width: 40px;
        height: 55px;
        object-fit: cover;
        border-radius: 3px;
    }
    
    .no-cover {
        width: 40px;
        height: 55px;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #4361ee;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .filter-btn.active {
        background-color: #4361ee;
        color: white;
        border-color: #4361ee;
    }
    
    .return-btn:hover {
        background-color: #28a745;
        color: white;
    }
    
    .lending-dates .text-muted {
        width: 50px;
        display: inline-block;
    }


    .pagination-container {
    margin-left: auto;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-item .page-link {
    color: #4361ee;
    border-radius: 3px;
    margin: 0 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 10px;
}

.pagination .page-item.active .page-link {
    background-color: #4361ee;
    border-color: #4361ee;
    color: white;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
}

.pagination .page-item .page-link:focus {
    box-shadow: 0 0 0 0.15rem rgba(67, 97, 238, 0.25);
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('lendingSearch');
        const table = document.getElementById('lendingsTable');
        const rows = table.querySelectorAll('tbody tr:not([data-empty])');
        
        // Update visible count function
        function updateVisibleCount() {
            const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"]):not([data-empty])');
            document.getElementById('visibleCount').textContent = visibleRows.length;
        }
        
        // Search filter
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            let visibleCount = 0;
            
            rows.forEach(row => {
                const bookTitle = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const borrowerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (bookTitle.includes(query) || borrowerName.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateVisibleCount();
        });
        
        // Status filter
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter rows
                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    if (filter === 'all' || status === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                updateVisibleCount();
            });
        });
        
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const closeButton = alert.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.click();
                }
            }, 5000);
        });
        
        // Confirm return action
        const returnForms = document.querySelectorAll('form[action*="lendings.return"]');
        returnForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to mark this book as returned?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection
@endhasanyrole