@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Buat Peran Baru</h2>

        <form method="POST" action="{{ route('roles.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Peran</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Izin Akses</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($permissions as $perm)
                        <label class="inline-flex items-center space-x-2 text-sm text-gray-600">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span>{{ $perm->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded hover:bg-green-700">
                    Buat Peran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
