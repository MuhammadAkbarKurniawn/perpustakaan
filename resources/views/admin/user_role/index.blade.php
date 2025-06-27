@extends('layouts.app')
@role('admin')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Manajemen Peran & Izin Pengguna</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-3 border-b">Pengguna</th>
                        <th class="px-4 py-3 border-b">Peran</th>
                        <th class="px-4 py-3 border-b">Izin</th>
                        <th class="px-4 py-3 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">
                            @forelse($user->roles as $role)
                                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded mr-1">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 text-xs">Tidak ada peran</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-3">
                            @forelse($user->permissions as $perm)
                                <span class="inline-block px-2 py-1 text-xs bg-gray-200 text-gray-800 rounded mr-1">
                                    {{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 text-xs">Tidak ada izin</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.user_role.edit', $user) }}"
                               class="inline-block px-3 py-1 bg-yellow-400 text-white text-xs font-medium rounded hover:bg-yellow-500">
                                Ubah
                            </a>
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
