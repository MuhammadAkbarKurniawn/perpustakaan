@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">
            Ubah Peran & Izin untuk <span class="text-blue-600">{{ $user->name }}</span>
        </h3>

        <form method="POST" action="{{ route('admin.user_role.update', $user) }}">
            @csrf
            @method('PUT')

            {{-- Pilih Peran --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center space-x-2 text-sm text-gray-700">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <span>{{ ucfirst($role->name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Pilih Izin --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Izin Langsung</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($permissions as $perm)
                        <label class="inline-flex items-center space-x-2 text-sm text-gray-700">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                   {{ $user->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                            <span>{{ ucfirst($perm->name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i> Perbarui Pengguna
                </button>
                <a href="{{ route('admin.user_role.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
