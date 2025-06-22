@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit Pengguna</h2>

    <form id="userEditForm" action="{{ route('users.update', $user->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
            <div class="invalid-feedback">Nama wajib diisi.</div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
            <div class="invalid-feedback">Silakan masukkan alamat email yang valid.</div>
        </div>

        <div class="mb-3">
            <label>Kata Sandi Baru <small class="text-muted">(biarkan kosong jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" class="form-control" minlength="6">
            <div class="invalid-feedback">Kata sandi minimal 6 karakter.</div>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation" class="form-control">
            <div class="invalid-feedback">Kata sandi harus sama.</div>
        </div>

        <div class="mb-3">
            <label>Peran Pengguna</label>
            <select name="role" class="form-select">
                <option value="">-- Tidak Ada --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Perbarui</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

{{-- Validasi Waktu Nyata --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('userEditForm');

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
