<!-- Judul -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
    <input type="text" name="title"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        value="{{ old('title', $book->title) }}" required minlength="3" maxlength="255">
    <p class="text-sm text-red-600 hidden">Judul harus 3-255 karakter.</p>
</div>

<!-- Penulis -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
    <input type="text" name="author"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        value="{{ old('author', $book->author) }}" required minlength="3" maxlength="255">
    <p class="text-sm text-red-600 hidden">Nama penulis harus 3-255 karakter.</p>
</div>

<!-- ISBN -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
    <input type="text" name="isbn"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        value="{{ old('isbn', $book->isbn) }}" required pattern="\d{13}">
    <p class="text-sm text-red-600 hidden">Masukkan ISBN 13 digit angka.</p>
</div>

<!-- Jumlah Eksemplar -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Eksemplar</label>
    <input type="number" name="total_copies"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        value="{{ old('total_copies', $book->total_copies) }}" required min="1">
    <p class="text-sm text-red-600 hidden">Jumlah minimal 1 eksemplar.</p>
</div>

<!-- Deskripsi -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
    <textarea name="description"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    >{{ old('description', $book->description) }}</textarea>
</div>

<!-- Gambar Sampul -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Sampul</label>
    <input type="file" name="cover_image"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    @if($book->cover_image)
        <small class="text-gray-500 block mt-1">Sampul saat ini:</small>
        <img src="{{ asset('storage/' . $book->cover_image) }}" width="100" class="mt-2 rounded">
    @endif
</div>

<!-- Checkbox Aktif -->
@if(Route::currentRouteName() === 'books.edit')
    <div class="flex items-center mb-4">
        <input class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" type="checkbox" name="is_active" value="1" {{ $book->is_active ? 'checked' : '' }}>
        <label class="ml-2 text-sm text-gray-700">Aktif</label>
    </div>
@endif
