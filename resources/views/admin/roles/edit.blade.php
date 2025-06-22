@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Ubah Peran: {{ $role->name }}</h3>

    <form method="POST" action="{{ route('roles.update', $role) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Perbarui Izin Akses</label>
            <div class="row">
                @foreach($permissions as $perm)
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                            {{ $perm->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button class="btn btn-primary">Perbarui Izin</button>
    </form>
</div>
@endsection
