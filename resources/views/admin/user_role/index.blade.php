@extends('layouts.app')
@role('admin')
@section('content')
<div class="container">
    <h3>Manajemen Peran & Izin Pengguna</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Peran</th>
                <th>Izin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    @foreach($user->permissions as $perm)
                        <span class="badge bg-secondary">{{ $perm->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.user_role.edit', $user) }}" class="btn btn-sm btn-warning">Ubah</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@endrole
