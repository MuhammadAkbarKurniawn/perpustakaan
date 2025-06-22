@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Tambah Pengguna</h2>

    <form id="userForm" action="{{ route('users.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
            <div class="invalid-feedback">Nama wajib diisi.</div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            <div class="invalid-feedback">Silakan masukkan email yang valid.</div>
        </div>

        <div class="mb-3">
            <label>Kata Sandi</label>
            <input type="password" name="password" class="form-control" required minlength="6">
            <div class="invalid-feedback">Kata sandi minimal 6 karakter.</div>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" class="form-control" required>
            <div class="invalid-feedback">Kata sandi harus sama.</div>
        </div>

        <div class="mb-3">
            <label>Peran Pengguna</label>
            <select name="role" class="form-select">
                <option value="">-- Tidak Ada --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- Validasi JS Inline --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('userForm');

        const password = form.querySelector('[name="password"]');
        const passwordConfirmation = form.querySelector('[name="password_confirmation"]');

        const validateField = (field) => {
            if (!field.checkValidity()) {
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        };

        const validatePasswordMatch = () => {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Kata sandi tidak cocok');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
            validateField(passwordConfirmation);
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
