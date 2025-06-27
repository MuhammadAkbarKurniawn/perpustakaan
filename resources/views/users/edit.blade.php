@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Pengguna</h2>

    <form id="userEditForm" action="{{ route('users.update', $user->id) }}" method="POST" novalidate class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Nama wajib diisi.</div>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Silakan masukkan alamat email yang valid.</div>
        </div>

        {{-- Kata Sandi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru
                <small class="text-gray-500">(biarkan kosong jika tidak ingin mengubah)</small>
            </label>
            <input type="password" name="password" minlength="6"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="text-red-500 text-sm mt-1 hidden">Kata sandi minimal 6 karakter.</div>
        </div>

        {{-- Konfirmasi Kata Sandi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation"
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
                    <option value="{{ $role->name }}"
                        {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                Perbarui
            </button>
            <a href="{{ route('users.index') }}"
               class="px-4 py-2 bg-gray-500 text-white text-sm rounded hover:bg-gray-600">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Validasi Waktu Nyata --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('userEditForm');
        const password = form.querySelector('[name="password"]');
        const passwordConfirmation = form.querySelector('[name="password_confirmation"]');

        const validateField = (field) => {
            const errorDiv = field.nextElementSibling;
            if (!field.checkValidity()) {
                field.classList.add('border-red-500');
                errorDiv.classList.remove('hidden');
            } else {
                field.classList.remove('border-red-500');
                errorDiv.classList.add('hidden');
            }
        };

        const validatePasswordMatch = () => {
            const errorDiv = passwordConfirmation.nextElementSibling;
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Mismatch');
                passwordConfirmation.classList.add('border-red-500');
                errorDiv.classList.remove('hidden');
            } else {
                passwordConfirmation.setCustomValidity('');
                passwordConfirmation.classList.remove('border-red-500');
                errorDiv.classList.add('hidden');
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
