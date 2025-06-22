@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Peminjaman Buku</h2>

    <form id="lendingForm" method="POST" action="{{ route('lendings.store') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label for="book_id">Pilih Buku</label>
            <select name="book_id" class="form-control" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} tersedia)</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Silakan pilih buku.</div>
        </div>

        <div class="mb-3">
            <label for="user_id">Pilih Anggota</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Silakan pilih anggota.</div>
        </div>

        <div class="mb-3">
            <label for="due_date">Tanggal Jatuh Tempo</label>
            <input type="date" name="due_at" class="form-control" required>
            <div class="invalid-feedback">Silakan pilih tanggal jatuh tempo yang valid.</div>
        </div>

        <button type="submit" class="btn btn-primary">Pinjam Buku</button>
    </form>
</div>

{{-- Skrip Validasi Realtime --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('lendingForm');

        const validateField = (field) => {
            if (!field.checkValidity()) {
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        };

        Array.from(form.elements).forEach(input => {
            if (input.tagName !== 'BUTTON') {
                input.addEventListener('input', () => validateField(input));
                input.addEventListener('change', () => validateField(input));
            }
        });

        form.addEventListener('submit', function (e) {
            let isFormValid = true;
            Array.from(form.elements).forEach(input => {
                validateField(input);
                if (!input.checkValidity()) {
                    isFormValid = false;
                }
            });

            if (!isFormValid) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
</script>
@endsection
