@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">📚 Peminjaman Buku</h2>

    <form id="lendingForm" method="POST" action="{{ route('lendings.store') }}" novalidate class="space-y-5 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Buku</label>
            <select name="book_id" class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 invalid:border-red-500 invalid:text-red-600 peer" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->available_copies }} tersedia)</option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-red-600 hidden peer-invalid:block">Silakan pilih buku.</p>
        </div>

        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Anggota</label>
            <select name="user_id" class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 invalid:border-red-500 invalid:text-red-600 peer" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <p class="mt-1 text-sm text-red-600 hidden peer-invalid:block">Silakan pilih anggota.</p>
        </div>

        <div>
            <label for="due_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
            <input type="date" name="due_at" class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 invalid:border-red-500 invalid:text-red-600 peer" required>
            <p class="mt-1 text-sm text-red-600 hidden peer-invalid:block">Silakan pilih tanggal jatuh tempo yang valid.</p>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold">
            Pinjam Buku
        </button>
    </form>
</div>

{{-- Skrip Validasi Realtime --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('lendingForm');

        const validateField = (field) => {
            if (!field.checkValidity()) {
                field.classList.add('border-red-500', 'text-red-600');
            } else {
                field.classList.remove('border-red-500', 'text-red-600');
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
