@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Pengguna</h2>

    <form id="userForm" action="{{ route('users.store') }}" method="POST" novalidate class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Nama wajib diisi.</div>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Silakan masukkan email yang valid.</div>
        </div>

        {{-- Kata Sandi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
            <input type="password" name="password" minlength="6" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Kata sandi minimal 6 karakter.</div>
        </div>

        {{-- Konfirmasi Kata Sandi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Kata sandi harus sama.</div>
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Peran Pengguna</label>
            <select name="role"
                class="w-full border rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Tidak Ada --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Simpan
            </button>
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Validasi JS Real-time --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('userForm');
        const password = form.querySelector('[name="password"]');
        const passwordConfirmation = form.querySelector('[name="password_confirmation"]');

        const validateField = (field) => {
            const error = field.nextElementSibling;
            if (!field.checkValidity()) {
                field.classList.add('border-red-500');
                error.classList.remove('hidden');
            } else {
                field.classList.remove('border-red-500');
                error.classList.add('hidden');
            }
        };

        const validatePasswordMatch = () => {
            const error = passwordConfirmation.nextElementSibling;
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Mismatch');
                passwordConfirmation.classList.add('border-red-500');
                error.classList.remove('hidden');
            } else {
                passwordConfirmation.setCustomValidity('');
                passwordConfirmation.classList.remove('border-red-500');
                error.classList.add('hidden');
            }
        };

        Array.from(form.elements).forEach(input => {
            if (input.tagName !== 'BUTTON') {
                input.addEventListener('input', () => {
                    if (input.name === 'password' || input.name === 'password_confirmation') {
                        validatePasswordMatch();
                    } else {
                        validateField(input);
                    }
                });
            }
        });

        form.addEventListener('submit', function (e) {
            validatePasswordMatch();

            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                Array.from(form.elements).forEach(validateField);
            }
        });
    });
</script>
@endsection
