@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 bg-white shadow rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Buku Baru</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" id="bookForm" class="space-y-6">
        @csrf

        @include('books._form', ['book' => new \App\Models\Book])

        <div>
            <button type="submit" id="submitBtn" disabled
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed">
                Simpan Buku
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('bookForm');
        const submitBtn = document.getElementById('submitBtn');
        const inputs = form.querySelectorAll('input, textarea');

        // Validasi langsung saat mengetik
        form.addEventListener('input', function () {
            let isValid = true;

            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            submitBtn.disabled = !isValid;
        });

        // Validasi sebelum submit
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            let formValid = true;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    formValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (formValid) {
                form.submit();
            }
        });
    });
</script>
@endpush
@endsection
