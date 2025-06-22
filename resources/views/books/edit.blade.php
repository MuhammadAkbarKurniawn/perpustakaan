@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Buku: {{ $book->title }}</h2>

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('books._form')
        <button type="submit" class="btn btn-success">Perbarui Buku</button>
    </form>
</div>
@endsection
