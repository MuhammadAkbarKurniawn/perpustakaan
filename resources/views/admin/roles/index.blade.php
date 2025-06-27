@extends('layouts.app')

@role('admin')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Peran</h2>
            <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                ➕ Tambah Peran Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600 border border-gray-200 rounded">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border">Nama Peran</th>
                        <th class="px-4 py-3 border">Izin Akses</th>
                        <th class="px-4 py-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($roles as $role)
                    <tr>
                        <td class="px-4 py-3 border font-medium text-gray-800">{{ $role->name }}</td>
                        <td class="px-4 py-3 border">
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->permissions as $perm)
                                    <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
                                        {{ $perm->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 border text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('roles.edit', $role) }}" class="px-3 py-1 text-sm bg-yellow-400 hover:bg-yellow-500 text-white rounded">
                                    Ubah
                                </a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Hapus peran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@endrole
