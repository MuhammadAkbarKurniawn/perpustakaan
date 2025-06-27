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
// Dashboard (login + verifikasi email)
// ------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ------------------------
// Admin &  Routes
// ------------------------
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard admin/
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD: Users, Books, Lendings, Roles
    Route::resource('users', UserController::class);
    Route::resource('books', BookController::class);
    Route::resource('lendings', LendingController::class);
    Route::resource('roles', RoleController::class);

    // Manajemen role & permission pengguna
    Route::get('/user-role', [UserRoleController::class, 'index'])->name('admin.user_role.index');
    Route::get('/user-role/{user}/edit', [UserRoleController::class, 'edit'])->name('admin.user_role.edit');
    Route::put('/user-role/{user}', [UserRoleController::class, 'update'])->name('admin.user_role.update');

    // Lihat riwayat peminjaman user
    Route::get('/users/{user}/borrowings', [UserController::class, 'borrowings'])->name('users.borrowings');

    // Pengembalian buku
    Route::post('/lendings/{lending}/return', [LendingController::class, 'returnBook'])->name('lendings.return');

    // Perpanjangan jatuh tempo peminjaman
    Route::patch('/lendings/{lending}/extend', [LendingController::class, 'extend'])->name('lendings.extend');
});

// ------------------------
// Admin, , Member - Lihat Daftar Buku
// ------------------------
Route::middleware(['auth', 'role:admin|member'])->get('/books', [BookController::class, 'index'])->name('books.index');

// ------------------------
// Member-only Routes
// ------------------------
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/my-books', [LendingController::class, 'myBorrowedBooks'])->name('lendings.my_books');
});



// ------------------------
// Profile Routes (semua login user)
// ------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ------------------------
// Auth Routes (Breeze / Fortify)
// ------------------------
require __DIR__.'/auth.php';
