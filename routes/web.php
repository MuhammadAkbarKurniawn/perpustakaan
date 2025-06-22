<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// ------------------------
// Dashboard umum (semua yang login dan terverifikasi)
// ------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ------------------------
// Admin & Librarian Routes
// ------------------------
Route::middleware(['auth', 'role:admin|librarian'])->group(function () {
    // Dashboard admin pakai controller
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Resource routes
    Route::resource('users', UserController::class);
    Route::resource('books', BookController::class);
    Route::resource('lendings', LendingController::class);
    Route::resource('roles', RoleController::class);

    // Role & permission management
    Route::get('/user-role', [UserRoleController::class, 'index'])->name('admin.user_role.index');
    Route::post('/user-role', [UserRoleController::class, 'assign'])->name('admin.user_role.assign');
});

// ------------------------
// Member-only Routes
// ------------------------
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/lendings/mine', [LendingController::class, 'myBorrowedBooks'])->name('lendings.mine');
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
});

// ------------------------
// Profile Routes
// ------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (from Laravel Breeze or Fortify)
require __DIR__.'/auth.php';
