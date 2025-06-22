<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\LendingRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $borrowedBooks = LendingRecord::whereNull('returned_at')->count();
        $availableBooks = Book::sum('available_copies');

        $recentLendings = LendingRecord::with('book', 'user')
            ->latest('borrowed_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'borrowedBooks',
            'availableBooks',
            'recentLendings'
        ));
    }
}
