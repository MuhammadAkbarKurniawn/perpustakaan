@extends('layouts.app')
@role('admin')
@section('content')
<div class="container">
    <h3 class="mb-3">Manajemen Peran</h3>

    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">➕ Tambah Peran Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Peran</th>
                <th>Izin Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach($role->permissions as $perm)
                            <span class="badge bg-secondary">{{ $perm->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus peran ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@endrole
