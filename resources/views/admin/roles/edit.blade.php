@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Ubah Peran: {{ $role->name }}</h2>

        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Peran</label>
                <input type="text" name="name" id="name" value="{{ $role->name }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Perbarui Izin Akses</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($permissions as $perm)
                        <label class="inline-flex items-center space-x-2 text-sm text-gray-600">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}
                                class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span>{{ $perm->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700">
                    Perbarui Izin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
