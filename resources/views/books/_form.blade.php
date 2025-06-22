<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required minlength="3" maxlength="255">
    <div class="invalid-feedback">Harap masukkan judul yang valid (antara 3 sampai 255 karakter).</div>
</div>

<div class="mb-3">
    <label>Penulis</label>
    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}" required minlength="3" maxlength="255">
    <div class="invalid-feedback">Harap masukkan nama penulis yang valid (antara 3 sampai 255 karakter).</div>
</div>

<div class="mb-3">
    <label>ISBN</label>
    <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}" required pattern="\d{13}">
    <div class="invalid-feedback">Harap masukkan ISBN yang valid (13 digit angka).</div>
</div>

<div class="mb-3">
    <label>Jumlah Eksemplar</label>
    <input type="number" name="total_copies" class="form-control" value="{{ old('total_copies', $book->total_copies) }}" required min="1">
    <div class="invalid-feedback">Harap masukkan jumlah eksemplar yang valid (minimal 1).</div>
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control">{{ old('description', $book->description) }}</textarea>
</div>

<div class="mb-3">
    <label>Gambar Sampul</label>
    <input type="file" name="cover_image" class="form-control">
    @if($book->cover_image)
        <small>Sampul saat ini:</small><br>
        <img src="{{ asset('storage/' . $book->cover_image) }}" width="100" class="mt-2">
    @endif
</div>

@if(Route::currentRouteName() === 'books.edit')
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $book->is_active ? 'checked' : '' }}>
        <label class="form-check-label">Aktif</label>
    </div>
@endif
