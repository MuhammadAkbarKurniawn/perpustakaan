@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Ubah Peran & Izin untuk <strong>{{ $user->name }}</strong></h3>

    <form method="POST" action="{{ route('admin.user_role.update', $user) }}">
        @csrf
        @method('PUT')

        {{-- Pilih Peran --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Peran</label>
            <div class="row">
                @foreach($roles as $role)
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   class="form-check-input" id="role-{{ $role->id }}"
                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-{{ $role->id }}">
                                {{ ucfirst($role->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pilih Izin --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Izin Langsung (Permission)</label>
            <div class="row">
                @foreach($permissions as $perm)
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                   class="form-check-input" id="perm-{{ $perm->id }}"
                                   {{ $user->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm-{{ $perm->id }}">
                                {{ ucfirst($perm->name) }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Perbarui Pengguna
            </button>
            <a href="{{ route('admin.user_role.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
