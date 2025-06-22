<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\LendingRecord;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalBooks' => Book::count(),
            'borrowedBooks' => LendingRecord::whereNull('returned_at')->count(),
            'availableBooks' => Book::sum('available_copies'),
            'recentLendings' => LendingRecord::with('user', 'book')->latest()->take(5)->get(),
        ]);
    }
}

