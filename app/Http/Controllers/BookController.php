<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    // Menampilkan semua buku
    public function index()
    {
       $books = Book::paginate(10); // atau sesuai kebutuhan

        if (auth()->user()->hasRole('member')) {
            return view('books.index_user', compact('books'));
        }

        return view('books.index', compact('books'));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        return view('books.create');
    }

    // Menyimpan buku baru
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        $validated['available_copies'] = $validated['total_copies'];

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Menampilkan form edit buku
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // Update data buku
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama jika ada
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $coverPath;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // Menghapus buku
    public function destroy(Book $book)
    {
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
