@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Buat Peran Baru</h3>

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Peran</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Izin Akses</label>
            <div class="row">
                @foreach($permissions as $perm)
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}">
                            {{ $perm->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button class="btn btn-success">Buat Peran</button>
    </form>
</div>
@endsection
