@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Buku: {{ $book->title }}</h2>

        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            @include('books._form')

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <i class="fas fa-save mr-1"></i> Perbarui Buku
            </button>
        </form>
    </div>
</div>
@endsection
