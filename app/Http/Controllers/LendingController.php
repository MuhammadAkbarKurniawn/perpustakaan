<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LendingRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLendingRequest;

class LendingController extends Controller
{
    // Menampilkan daftar semua peminjaman (untuk admin)
    public function index()
    {
        // Hanya admin bisa akses semua peminjaman
        if (Auth::user()->hasRole('admin')) {
            $lendings = LendingRecord::with('book', 'user')->orderByDesc('borrowed_at')->paginate(10);
            return view('lendings.index', compact('lendings'));
        }

        // User biasa hanya melihat peminjamannya sendiri
        return redirect()->route('lendings.my')->with('warning', 'Akses tidak diizinkan.');
    }

    // Menampilkan daftar peminjaman user yang sedang login
    public function myBorrowedBooks()
    {
        $lendings = LendingRecord::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('borrowed_at')
            ->get();

        return view('lendings.my_books', compact('lendings'));
    }

    // Menampilkan form peminjaman
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $users = User::role('member')->get(); // pastikan role 'member' ada

        return view('lendings.create', compact('books', 'users'));
    }

    // Menyimpan data peminjaman
    public function store(StoreLendingRequest $request)
    {
        $validated = $request->validated();
        $book = Book::findOrFail($validated['book_id']);

        if ($book->available_copies <= 0) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia.']);
        }

        LendingRecord::create([
            'book_id'     => $validated['book_id'],
            'user_id'     => $validated['user_id'],
            'borrowed_at' => now(),
            'due_at'      => $validated['due_at'],
            'returned_at' => null,
        ]);

        $book->decrement('available_copies');

        return redirect()->route('lendings.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    // Mengembalikan buku
    public function returnBook(LendingRecord $lending)
    {
        if ($lending->returned_at) {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
        }

        $lending->update(['returned_at' => now()]);
        $lending->book->increment('available_copies');

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    // Menghapus data peminjaman
    public function destroy(LendingRecord $lending)
    {
        if (!$lending->returned_at) {
            $lending->book->increment('available_copies');
        }

        $lending->delete();

        return redirect()->route('lendings.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function extend(Request $request, $id)
    {
        $request->validate([
            'due_at' => 'required|date|after_or_equal:today',
        ]);

        $lending = \App\Models\LendingRecord::findOrFail($id);
        $lending->due_at = $request->due_at;
        $lending->save();

        return redirect()->route('lendings.index')->with('success', 'Tanggal jatuh tempo berhasil diperpanjang.');
    }

    
    
}
