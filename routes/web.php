<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;

// ------------------------
// Halaman awal
// ------------------------
Route::get('/', function () {
    return view('welcome');
});

// ------------------------
// Dashboard (akses setelah login dan verifikasi email)
// ------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ------------------------
// Admin & Librarian Routes
// ------------------------
Route::middleware(['auth', 'role:admin|librarian'])->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Resource routes (CRUD)
    Route::resource('users', UserController::class);
    Route::resource('books', BookController::class); // CRUD untuk admin/librarian
    Route::resource('lendings', LendingController::class);
    Route::resource('roles', RoleController::class);

    // Role & permission management
    Route::get('/user-role', [UserRoleController::class, 'index'])->name('admin.user_role.index');
    Route::post('/user-role', [UserRoleController::class, 'assign'])->name('admin.user_role.assign');

    // Melihat riwayat peminjaman per pengguna
    Route::get('/users/{user}/borrowings', [UserController::class, 'borrowings'])->name('users.borrowings');

    // ✅ Route tambahan untuk mengembalikan buku
    Route::post('/lendings/{lending}/return', [LendingController::class, 'returnBook'])->name('lendings.return');
});

// ------------------------
// Route yang dapat diakses oleh admin, librarian, dan member
// (khusus untuk melihat daftar buku)
// ------------------------
Route::middleware(['auth', 'role:admin|librarian|member'])->get('/books', [BookController::class, 'index'])->name('books.index');

// ------------------------
// Member-only Routes
// ------------------------
Route::middleware(['auth', 'role:member'])->group(function () {
    // Buku yang sedang dipinjam oleh member ini sendiri
    Route::get('/lendings/mine', [LendingController::class, 'myBorrowedBooks'])->name('lendings.mine');
});

// ------------------------
// Profile Routes (semua yang login)
// ------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ------------------------
// Auth Routes (Laravel Breeze / Fortify)
// ------------------------
require __DIR__.'/auth.php';
